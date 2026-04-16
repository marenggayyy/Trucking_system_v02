<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Employee;
use App\Models\Trip;
use App\Models\Truck;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Driver\Driver;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q'); // search text
        $sort = $request->get('sort', 'dispatch_date');
        $dir = $request->get('dir', 'desc');

        // ✅ allowlist sorting columns (safe)
        $allowedSorts = ['trip_ticket_no', 'dispatch_date', 'status', 'dispatched_at', 'id'];
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'dispatch_date';
        }
        if (!in_array($dir, ['asc', 'desc'], true)) {
            $dir = 'desc';
        }
        

        // ✅ Trips query
        $tripsQuery = Trip::with(['destination', 'truck', 'driver', 'helpers'])->whereNotIn('status', ['Completed']);

        // ✅ Search (adjust fields if needed)
        if ($q) {
            $tripsQuery->where(function ($w) use ($q) {
                $w->where('trip_ticket_no', 'like', "%{$q}%")
                    ->orWhere('status', 'like', "%{$q}%")
                    ->orWhereHas('destination', function ($d) use ($q) {
                        $d->where('store_name', 'like', "%{$q}%")->orWhere('store_code', 'like', "%{$q}%");
                    })
                    ->orWhereHas('truck', function ($t) use ($q) {
                        $t->where('plate_number', 'like', "%{$q}%");
                    })
                    ->orWhereHas('driver', function ($dr) use ($q) {
                        $dr->where('name', 'like', "%{$q}%");
                    })
                    ->orWhereHas('helpers', function ($h) use ($q) {
                        $h->where('name', 'like', "%{$q}%");
                    });
            });
        }

        // ✅ Sort + Pagination (10 per page)

        $perPage = (int) $request->get('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

        // SEARCH
        if ($request->filled('q')) {
            $q = $request->q;
            $tripsQuery->where(function ($qq) use ($q) {
                $qq->where('trip_ticket_no', 'like', "%{$q}%");
                // add more fields here if needed
            });
        }

        // SORT (your existing logic)
        $trips = $tripsQuery
            ->orderByRaw(
                "
        CASE
    WHEN status = 'Draft' THEN 1
    WHEN status = 'Dispatched' THEN 2
    WHEN status = 'Completed' THEN 3
    WHEN status = 'Cancelled' THEN 4
END
    ",
            )
            ->orderByDesc('dispatch_date')
            ->paginate($perPage)
            ->withQueryString();

        // ✅ Data for "Create Trip" modal (your existing)
        $destinations = Destination::orderBy('store_name')->get();
        $trucks = Truck::where('status', 'active')->get();
        $drivers = Employee::where('employment_status', 'active')->where('default_role', 'driver')->get();
        $helpers = Employee::where('employment_status', 'active')->where('default_role', 'helper')->get();

        // ✅ OPTIONAL: for the “Available” cards list
        // (Change logic depending on your meaning of "available")
        $availableTrucks = Truck::where('status', 'active')->get();
        $availableDrivers = Employee::where('availability_status', 'available')->where('default_role', 'driver')->get();
        $availableHelpers = Employee::where('availability_status', 'available')->where('default_role', 'helper')->get();

        return view('owner.trips.index', compact('trips', 'destinations', 'trucks', 'drivers', 'helpers', 'q', 'sort', 'dir', 'availableTrucks', 'availableDrivers', 'availableHelpers'));
    }

    public function create()
    {
        return view('owner.trips.create');
    }

    public function edit($id)
    {
        return view('owner.trips.edit');
    }

    public function show($id)
    {
        return view('owner.trips.show');
    }
}
