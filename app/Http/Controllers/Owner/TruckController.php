<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Truck;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    public function index()
    {
        $sixWTrucks = Truck::where('truck_type', '6W')
            ->latest()
            ->paginate(10, ['*'], 'sixw_page');

        $l300Trucks = Truck::where('truck_type', 'L300')
            ->latest()
            ->paginate(10, ['*'], 'l300_page');

        $stats = [
            'total' => Truck::count(),
            'available' => Truck::where('status', 'active')->count(),
            'on_trip' => Truck::where('status', 'on_trip')->count(),
            'out_of_service' => Truck::where('status', 'inactive')->count(),
        ];

        return view('owner.trucks.index', compact(
            'sixWTrucks',
            'l300Trucks',
            'stats'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|max:50|unique:trucks,plate_number',
            'truck_type' => 'required|in:L300,6W',
            'status' => 'required|in:active,inactive,on_trip',
        ]);

        Truck::create($validated);

        return back()->with('success', 'Truck added successfully.');
    }

    public function update(Request $request, Truck $truck)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|max:50|unique:trucks,plate_number,' . $truck->id,
            'truck_type' => 'required|in:L300,6W',
            'status' => 'required|in:active,inactive,on_trip',
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
            Truck::where('truck_type', $request->truck_type)->delete();

            return back()->with('success', "{$request->truck_type} trucks deleted successfully.");
        }

        Truck::truncate();

        return back()->with('success', 'All trucks deleted successfully.');
    }

    public function sidebar(Truck $truck)
    {
        return view('owner.trucks.partials.sidebar', compact('truck'));
    }
}