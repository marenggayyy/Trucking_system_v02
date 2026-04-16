<?php

namespace App\Http\Controllers\Owner;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('name')->get();

        $drivers = $employees->where('default_role', 'driver')->values();
        $helpers = $employees->where('default_role', 'helper')->values();

        /*
        |--------------------------------------------------------------------------
        | DRIVER GROUPS
        |--------------------------------------------------------------------------
        */
        $availableDrivers = $drivers->filter(fn($e) => $e->employment_status === 'active' && $e->availability_status === 'available');

        $onTripDrivers = $drivers->filter(fn($e) => $e->employment_status === 'active' && $e->availability_status === 'on_trip');

        $onLeaveDrivers = $drivers->filter(fn($e) => $e->employment_status === 'on-leave' || $e->availability_status === 'on_leave');

        $inactiveDrivers = $drivers->filter(fn($e) => $e->employment_status === 'inactive');

        /*
        |--------------------------------------------------------------------------
        | HELPER GROUPS
        |--------------------------------------------------------------------------
        */
        $availableHelpers = $helpers->filter(fn($e) => $e->employment_status === 'active' && $e->availability_status === 'available');

        $onTripHelpers = $helpers->filter(fn($e) => $e->employment_status === 'active' && $e->availability_status === 'on_trip');

        $onLeaveHelpers = $helpers->filter(fn($e) => $e->employment_status === 'on-leave' || $e->availability_status === 'on_leave');

        $inactiveHelpers = $helpers->filter(fn($e) => $e->employment_status === 'inactive');

        /*
        |--------------------------------------------------------------------------
        | STATS
        |--------------------------------------------------------------------------
        */
        $stats = [
            'total_drivers' => $drivers->count(),
            'total_helpers' => $helpers->count(),

            'driver_avail' => $availableDrivers->count(),
            'helper_avail' => $availableHelpers->count(),

            'on_trip_drivers' => $onTripDrivers->count(),
            'on_trip_helpers' => $onTripHelpers->count(),

            'on_leave' => $onLeaveDrivers->count() + $onLeaveHelpers->count(),
            'inactive' => $inactiveDrivers->count() + $inactiveHelpers->count(),
        ];

        return view('owner.employees.index', compact('drivers', 'helpers', 'stats', 'availableDrivers', 'availableHelpers', 'onTripDrivers', 'onTripHelpers', 'onLeaveDrivers', 'onLeaveHelpers', 'inactiveDrivers', 'inactiveHelpers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'default_role' => 'required|in:driver,helper',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:employees,email',
            'employment_status' => 'nullable|in:active,inactive,on-leave',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $employmentStatus = $request->employment_status ?? 'active';

        $data = [
            'default_role' => $request->default_role,
            'name' => $request->name,
            'email' => $request->email,
            'employment_status' => $employmentStatus,
        ];

        if ($employmentStatus === 'inactive') {
            $data['availability_status'] = 'unavailable';
        } elseif ($employmentStatus === 'on-leave') {
            $data['availability_status'] = 'on_leave';
        } else {
            $data['availability_status'] = 'available';
        }

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('employees', 'public');
        }

        Employee::create($data);

        return back()->with('success', 'Employee added successfully.');
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:employees,email,' . $employee->id,
            'employment_status' => 'nullable|in:active,inactive,on-leave',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $employmentStatus = $request->employment_status ?? $employee->employment_status;

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'employment_status' => $employmentStatus,
        ];

        if ($employmentStatus === 'inactive') {
            $data['availability_status'] = 'unavailable';
        } elseif ($employmentStatus === 'on-leave') {
            $data['availability_status'] = 'on_leave';
        }

        if ($request->hasFile('profile_photo')) {
            if ($employee->profile_photo && Storage::disk('public')->exists($employee->profile_photo)) {
                Storage::disk('public')->delete($employee->profile_photo);
            }

            $data['profile_photo'] = $request->file('profile_photo')->store('employees', 'public');
        }

        $employee->update($data);

        return back()->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->profile_photo && Storage::disk('public')->exists($employee->profile_photo)) {
            Storage::disk('public')->delete($employee->profile_photo);
        }

        $employee->delete();

        return back()->with('success', 'Employee deleted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = collect(explode(',', (string) $request->employee_ids))->filter()->map(fn($id) => (int) $id)->values();

        if ($ids->isEmpty()) {
            return back()->with('error', 'No employees selected.');
        }

        Employee::whereIn('id', $ids)->delete();

        return back()->with('success', 'Selected employees deleted.');
    }

    public function destroyAll(Request $request)
    {
        $role = $request->default_role;

        if ($role) {
            Employee::where('default_role', $role)->delete();

            return back()->with('success', ucfirst($role) . 's deleted successfully.');
        }

        Employee::truncate();

        return back()->with('success', 'All employees deleted successfully.');
    }

    public function sidebar(Employee $employee)
    {
        return view('owner.employees.partials.sidebar', compact('employee'));
    }
}
