<?php

namespace App\Http\Controllers\Owner;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();

        // SEARCH
        $q = trim($request->q);
        if (!empty($q)) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('default_role', 'like', "%$q%");
            });
        }

        // ROLE FILTER
        $role = $request->role;
        if (!empty($role) && $role !== 'all') {
            $query->where('default_role', $role);
        }

        $employees = $query->latest()->get();

        $stats = [
            'drivers' => $employees->where('default_role', 'driver')->count(),
            'helpers' => $employees->where('default_role', 'helper')->count(),
            'on_leave' => $employees->where('employment_status', 'on_leave')->count(),
            'inactive' => $employees->where('employment_status', 'inactive')->count(),
            'available_drivers' => $employees->where('default_role', 'driver')->where('availability_status', 'available')->count(),
            'on_trip_drivers' => $employees->where('default_role', 'driver')->where('availability_status', 'on_trip')->count(),
            'available_helpers' => $employees->where('default_role', 'helper')->where('availability_status', 'available')->count(),
            'on_trip_helpers' => $employees->where('default_role', 'helper')->where('availability_status', 'on_trip')->count(),
        ];

        return view('owner.employees.index', compact('employees', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'default_role' => 'required|in:driver,helper',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:employees,email',
            'employment_status' => 'nullable|in:active,inactive,on_leave',
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
        } elseif ($employmentStatus === 'on_leave') {
            $data['availability_status'] = 'on_leave';
        } else {
            $data['availability_status'] = 'available';
        }

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('employees', 'public');
        }

        Employee::create($data);

        return redirect()
            ->route('owner.employees.index', [
                'role' => request('role'),
                'q' => request('q'),
            ])
            ->with('success', 'Employee added successfully.');
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:employees,email,' . $employee->id,
            'employment_status' => 'nullable|in:active,inactive,on_leave',
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
        } elseif ($employmentStatus === 'on_leave') {
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
