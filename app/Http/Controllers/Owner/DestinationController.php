<?php

namespace App\Http\Controllers\Owner;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DestinationRate;
use App\Models\Company;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $tab = $request->get('tab', '6w');

        $destinationsQuery = Destination::with('rates');

        if ($q) {
            $destinationsQuery->where(function ($w) use ($q) {
                $w->where('store_code', 'like', "%{$q}%")
                    ->orWhere('store_name', 'like', "%{$q}%")
                    ->orWhere('area', 'like', "%{$q}%");
            });
        }

        $perPage = 8;

        $destinations6w = (clone $destinationsQuery)
            ->whereHas('rates', fn($q) => $q->where('truck_type', '6W'))
            ->orderBy('store_name')
            ->paginate($perPage, ['*'], 'page6w')
            ->withQueryString();

        $destinationsL300 = (clone $destinationsQuery)
            ->whereHas('rates', fn($q) => $q->where('truck_type', 'L300'))
            ->orderBy('store_name')
            ->paginate($perPage, ['*'], 'pageL300')
            ->withQueryString();

        $companies = Company::orderBy('name')->get();

        return view('owner.destinations.index', compact('destinations6w', 'destinationsL300', 'q', 'tab', 'companies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'store_code' => ['required', 'string', 'max:50'],
            'store_name' => ['required', 'string', 'max:255'],
            'area' => ['nullable', 'string', 'max:255'],
            'truck_type' => ['required', 'in:6W,L300'],
            'rate' => ['required', 'numeric', 'min:0'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Find Existing Destination First
        |--------------------------------------------------------------------------
        */
        $destination = Destination::firstOrCreate(
            [
                'company_id' => $data['company_id'],
                'store_code' => $data['store_code'],
            ],
            [
                'store_name' => $data['store_name'],
                'area' => $data['area'] ?? null,
            ],
        );

        /*
        |--------------------------------------------------------------------------
        | Add / Update Truck Rate
        |--------------------------------------------------------------------------
        */
        $destination->rates()->updateOrCreate(
            [
                'truck_type' => $data['truck_type'],
            ],
            [
                'rate' => $data['rate'],
            ],
        );

        return back()->with('success', 'Destination saved successfully!');
    }

    public function destroy(Destination $destination, $truck_type)
    {
        // delete only specific rate
        $destination->rates()->where('truck_type', $truck_type)->delete();

        // if no more rates → delete destination
        if ($destination->rates()->count() === 0) {
            $destination->delete();
        }

        return back()->with('success', 'Rate deleted.');
    }

    public function update(Request $request, Destination $destination)
    {
        $data = $request->validate([
            'store_code' => ['required', 'string', 'max:50'],
            'store_name' => ['required', 'string', 'max:255'],
            'area' => ['nullable', 'string', 'max:255'],
            'truck_type' => ['required', 'in:6W,L300'],
            'rate' => ['required', 'numeric', 'min:0'],
        ]);

        $destination->update([
            'store_code' => $data['store_code'],
            'store_name' => $data['store_name'],
            'area' => $data['area'] ?? null,
        ]);

        $destination->rates()->updateOrCreate(['truck_type' => $data['truck_type']], ['rate' => $data['rate']]);

        return back()->with('success', 'Destination updated.');
    }
}
