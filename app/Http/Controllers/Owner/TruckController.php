<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Truck;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TruckController extends Controller
{
    public function index()
    {
        $sixWTrucks = Truck::where('truck_type', '6W')->latest()->get();
        $l300Trucks = Truck::where('truck_type', 'L300')->latest()->get();

        $stats = [
            'total' => Truck::count(),
            'available' => Truck::where('status', 'available')->count(),
            'on_trip' => Truck::where('status', 'on_trip')->count(),
            'out_of_service' => Truck::whereIn('status', ['on_maintenance', 'unavailable'])->count(),
        ];

        $companies = Company::orderBy('name')->get();

        return view('owner.trucks.index', compact('sixWTrucks', 'l300Trucks', 'stats', 'companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'plate_number' => 'required|string|max:50|unique:trucks,plate_number',
            'truck_type' => 'required|in:L300,6W',
            'status' => 'required|in:available,on_trip,on_maintenance,unavailable',
        ]);

        /*
        |--------------------------------------------------------------------------
        | DEFAULT AVAILABILITY
        |--------------------------------------------------------------------------
        */
        $validated['availability_status'] = 'available';

        Truck::create($validated);

        return back()->with('success', 'Truck added successfully.');
    }

    public function update(Request $request, Truck $truck)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'plate_number' => ['required', 'string', 'max:50', Rule::unique('trucks', 'plate_number')->ignore($truck->id)],
            'truck_type' => 'required|in:L300,6W',
            'status' => 'required|in:available,on_trip,on_maintenance,unavailable',
        ]);

        $truck->update($validated);

        return back()->with('success', 'Truck updated successfully.');
    }

    public function destroy(Truck $truck)
    {
        $truck->delete();

        return back()->with('success', 'Truck deleted successfully.');
    }

    public function destroyAll(Request $request)
    {
        if ($request->filled('truck_type')) {
            $trucks = Truck::where('truck_type', $request->truck_type)->get();

            foreach ($trucks as $truck) {
                $truck->trips()->delete();
                $truck->delete();
            }

            return redirect()
                ->route('owner.trucks.index')
                ->with('success', "{$request->truck_type} trucks deleted successfully.");
        }

        $trucks = Truck::all();

        foreach ($trucks as $truck) {
            $truck->trips()->delete();
            $truck->delete();
        }

        return redirect()->route('owner.trucks.index')->with('success', 'All trucks deleted successfully.');
    }

    public function sidebar(Truck $truck)
    {
        return view('owner.trucks.partials.sidebar', compact('truck'));
    }
}
