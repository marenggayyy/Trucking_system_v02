@extends('layouts.owner')

@section('title', 'Employees - Drivers & Helpers')

@section('content')
    <div class="container-fluid py-4">

        {{-- Header (TEAM UI HERO) --}}
        <div class="ui-hero p-4 mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <h4 class="mb-1 fw-bold">Drivers & Crew</h4>
                    <div class="text-muted small">
                        Availability, performance, and risk overview.
                    </div>
                </div>
            </div>
        </div>

        {{-- SUMMARY CARDS (Available-style) --}}
        <div class="row g-3 mb-1">

            {{-- TOTAL DRIVERS --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card ui-available-card border-bottom border-4 border-0 border-primary"
                    style="margin-bottom:10px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small fw-semibold">
                                Total Drivers 👤
                            </div>
                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <div class="ui-available-number text-primary">
                                    {{ $stats['drivers'] ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TOTAL HELPERS --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card ui-available-card border-bottom border-4 border-0 border-info" style="margin-bottom:10px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small fw-semibold">
                                Total Helpers 👷
                            </div>
                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <div class="ui-available-number text-info">
                                    {{ $stats['helpers'] ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ON LEAVE --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card ui-available-card border-bottom border-4 border-0 border-info" style="margin-bottom:10px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small fw-semibold">
                                On Leave 🏖️
                            </div>
                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <div class="ui-available-number text-info">
                                    {{ $stats['on_leave'] ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- INACTIVE --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card ui-available-card border-bottom border-4 border-0 border-danger"
                    style="margin-bottom:10px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small fw-semibold">
                                Inactive ⛔
                            </div>
                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <div class="ui-available-number text-danger">
                                    {{ $stats['inactive'] ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DRIVER AVAILABLE --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card ui-available-card border-bottom border-4 border-0 border-success"
                    style="margin-bottom:10px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small fw-semibold">
                                Driver Available ✅
                            </div>

                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <div class="ui-available-number text-success">
                                    {{ $stats['available_drivers'] ?? 0 }}
                                </div>

                                <button type="button" class="btn btn-sm ui-eye-btn" data-bs-target="#availDriversList"
                                    aria-controls="availDriversList" aria-expanded="false">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="collapse mt-0 ui-available-dropdown" id="availDriversList">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-2">

                            <div class="ui-paginated-list" data-per-page="5" data-target="drivers">
                                @php
                                    $availableDrivers = $employees
                                        ->where('default_role', 'driver')
                                        ->where('availability_status', 'available');
                                @endphp

                                @forelse($availableDrivers as $dr)
                                    <div class="ui-list-item py-1 small">{{ $dr->name }}</div>
                                @empty
                                    <div class="text-muted small">No available drivers.</div>
                                @endforelse
                            </div>

                            @if (($stats['available_drivers'] ?? 0) > 5)
                                <div class="d-flex justify-content-end align-items-center gap-2 mt-2 ui-list-controls"
                                    data-controls="drivers">
                                    <button type="button" class="btn btn-sm btn-light ui-list-prev">Prev</button>
                                    <div class="small text-muted ui-list-page">1</div>
                                    <button type="button" class="btn btn-sm btn-light ui-list-next">Next</button>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            {{-- ON TRIP DRIVERS --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card ui-available-card border-bottom border-4 border-0 border-primary"
                    style="margin-bottom:10px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small fw-semibold">
                                On Trip Drivers 🚚
                            </div>

                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <div class="ui-available-number text-primary">
                                    {{ $stats['on_trip_drivers'] ?? 0 }}
                                </div>

                                <button type="button" class="btn btn-sm ui-eye-btn" data-bs-target="#onTripDriversList"
                                    aria-controls="onTripDriversList" aria-expanded="false">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="collapse mt-0 ui-available-dropdown" id="onTripDriversList">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-2">

                            <div class="ui-paginated-list" data-per-page="5" data-target="ontripdrivers">
                                @php
                                    $onTripDrivers = $employees
                                        ->where('default_role', 'driver')
                                        ->where('availability_status', 'on_trip');
                                @endphp

                                @forelse($onTripDrivers as $dr)
                                    <div class="ui-list-item py-1 small">{{ $dr->name }}</div>
                                @empty
                                    <div class="text-muted small">No on-trip drivers.</div>
                                @endforelse
                            </div>

                            @if (($stats['on_trip_drivers'] ?? 0) > 5)
                                <div class="d-flex justify-content-end align-items-center gap-2 mt-2 ui-list-controls"
                                    data-controls="ontripdrivers">
                                    <button type="button" class="btn btn-sm btn-light ui-list-prev">Prev</button>
                                    <div class="small text-muted ui-list-page">1</div>
                                    <button type="button" class="btn btn-sm btn-light ui-list-next">Next</button>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            {{-- HELPER AVAILABLE --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card ui-available-card border-bottom border-4 border-0 border-warning"
                    style="margin-bottom:10px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small fw-semibold">
                                Helper Available ✅
                            </div>

                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <div class="ui-available-number text-warning">
                                    {{ $stats['available_helpers'] ?? 0 }}
                                </div>

                                {{-- NOTE: Removed data-bs-toggle so we can toggle manually --}}
                                <button type="button" class="btn btn-sm ui-eye-btn" data-bs-target="#availHelpersList"
                                    aria-controls="availHelpersList" aria-expanded="false">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="collapse mt-0 ui-available-dropdown" id="availHelpersList">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-2">
                            <div class="ui-paginated-list" data-per-page="5" data-target="helpers">
                                @php
                                    $onTripHelpers = $employees
                                        ->where('default_role', 'helper')
                                        ->where('availability_status', 'available');
                                @endphp

                                @forelse($onTripHelpers as $h)
                                    <div class="ui-list-item py-1 small">{{ $h->name }}</div>
                                @empty
                                    <div class="text-muted small">No available helpers.</div>
                                @endforelse
                            </div>

                            @if (($stats['available_helpers'] ?? 0) > 5)
                                <div class="d-flex justify-content-end align-items-center gap-2 mt-2 ui-list-controls"
                                    data-controls="helpers">
                                    <button type="button" class="btn btn-sm btn-light ui-list-prev">Prev</button>
                                    <div class="small text-muted ui-list-page">1</div>
                                    <button type="button" class="btn btn-sm btn-light ui-list-next">Next</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- ON TRIP HELPERS --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card ui-available-card border-bottom border-4 border-0 border-warning"
                    style="margin-bottom:10px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small fw-semibold">
                                On Trip Helpers 🚚
                            </div>

                            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                                <div class="ui-available-number text-warning">
                                    {{ $stats['on_trip_helpers'] ?? 0 }}
                                </div>

                                <button type="button" class="btn btn-sm ui-eye-btn" data-bs-target="#onTripHelpersList"
                                    aria-controls="onTripHelpersList" aria-expanded="false">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="collapse mt-0 ui-available-dropdown" id="onTripHelpersList">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-2">

                            <div class="ui-paginated-list" data-per-page="5" data-target="ontriphelpers">
                                @forelse(($onTripHelpers ?? collect()) as $h)
                                    <div class="ui-list-item py-1 small">{{ $h->name }}</div>
                                @empty
                                    <div class="text-muted small">No on-trip helpers.</div>
                                @endforelse
                            </div>

                            @if (($stats['on_trip_helpers'] ?? 0) > 5)
                                <div class="d-flex justify-content-end align-items-center gap-2 mt-2 ui-list-controls"
                                    data-controls="ontriphelpers">
                                    <button type="button" class="btn btn-sm btn-light ui-list-prev">Prev</button>
                                    <div class="small text-muted ui-list-page">1</div>
                                    <button type="button" class="btn btn-sm btn-light ui-list-next">Next</button>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Driver List --}}
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0">
                <div class="ui-people-header">
                    <div>

                        <h5 class="mb-1 fw-bold ui-people-title">Drivers & Helpers</h5>

                        {{-- FILTER BUTTONS (NOW BELOW TITLE) --}}
                        <div class="btn-group mt-1" id="roleFilter">
                            <a href="{{ route('owner.employees.index', ['role' => 'all', 'q' => request('q')]) }}"
                                class="btn btn-sm btn-outline-secondary {{ request('role') == 'all' ? 'active' : '' }}">
                                All
                                </a>

                                <a href="{{ route('owner.employees.index', ['role' => 'driver', 'q' => request('q')]) }}"
                                    class="btn btn-sm btn-outline-primary {{ request('role') == 'driver' ? 'active' : '' }}">
                                    Driver
                                </a>

                                <a href="{{ route('owner.employees.index', ['role' => 'helper', 'q' => request('q')]) }}"
                                    class="btn btn-sm btn-outline-info {{ request('role') == 'helper' ? 'active' : '' }}">
                                    Helper
                                </a>
                        </div>

                    </div>

                    <div class="ui-people-actions">

                        <form method="GET" action="{{ route('owner.employees.index') }}">
                            <input type="hidden" name="role" value="{{ request('role') }}">

                            <div class="ui-searchbox">
                                <i class="bi bi-search"></i>

                                <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                                    placeholder="Search">

                                <button type="submit" class="ui-search-clear">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                        <button class="btn btn-sm btn-primary ui-people-btn ui-people-btn--add" data-bs-toggle="modal"
                            data-bs-target="#addPersonModal">
                            ➕ Add
                        </button>

                        <form method="POST" action="{{ route('owner.employees.destroyAll') }}"
                            onsubmit="return confirm('Delete ALL employees?')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger ui-people-btn">
                                🗑️ Delete All
                            </button>
                        </form>

                    </div>
                </div>

                {{-- ADD MODAL (Driver / Helper) --}}
                <div class="modal fade" id="addPersonModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">Add Driver / Helper</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form method="POST" action="{{ route('owner.employees.store') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <select name="default_role" class="form-select" required>
                                            <option value="">-- Select --</option>
                                            <option value="driver">Driver</option>
                                            <option value="helper">Helper</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Profile Picture</label>
                                        <input type="file" name="profile_photo" class="form-control"
                                            accept="image/*">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="employment_status" class="form-select" required>
                                            <option value="active">Active</option>
                                            <option value="on_leave">On Leave</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- EDIT MODAL (Driver / Helper) --}}
                @foreach ($employees as $emp)
                    <div class="modal fade" id="editEmployeeModal{{ $emp->id }}" tabindex="-1">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Edit Employee</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form method="POST" action="{{ route('owner.employees.update', $emp->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label class="form-label">Profile Picture</label>
                                            <input type="file" name="profile_photo" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" value="{{ $emp->name }}"
                                                class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" value="{{ $emp->email }}"
                                                class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="employment_status" class="form-select">
                                                <option value="active"
                                                    {{ $emp->employment_status == 'active' ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="on_leave"
                                                    {{ $emp->employment_status == 'on_leave' ? 'selected' : '' }}>On Leave
                                                </option>
                                                <option value="inactive"
                                                    {{ $emp->employment_status == 'inactive' ? 'selected' : '' }}>Inactive
                                                </option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-primary">Update</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="card-body" style= "padding-right: 0; padding-left: 0; ">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th style="width:40px;">
                                    <input type="checkbox" id="selectAllEmployees" class="form-check-input">
                                </th>
                                <th>Employee</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Availability</th>
                                <th style="width:120px;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($employees as $emp)
                                <tr data-role="{{ $emp->default_role }}">

                                    {{-- CHECKBOX --}}
                                    <td>
                                        <input type="checkbox" class="form-check-input employee-check"
                                            value="{{ $emp->id }}">
                                    </td>

                                    {{-- NAME + AVATAR + EMAIL --}}
                                    <td>
                                        <div class="d-flex align-items-center gap-2">

                                            {{-- AVATAR --}}
                                            <img src="{{ $emp->profile_photo ? asset('storage/' . $emp->profile_photo) : asset('assets/images/page-img/14.png') }}"
                                                style="width:40px;height:40px;border-radius:50%;object-fit:cover;">

                                            <div>
                                                <div class="fw-semibold">{{ $emp->name }}</div>
                                                <div class="text-muted small">
                                                    {{ $emp->email ?? '—' }}
                                                </div>
                                            </div>

                                        </div>
                                    </td>

                                    {{-- ROLE --}}
                                    <td>
                                        <span
                                            class="badge {{ $emp->default_role === 'driver' ? 'bg-primary' : 'bg-info' }}">
                                            {{ ucfirst($emp->default_role) }}
                                        </span>
                                    </td>

                                    {{-- EMPLOYMENT STATUS --}}
                                    <td>
                                        <span
                                            class="badge 
                        @if ($emp->employment_status === 'active') bg-success
                        @elseif($emp->employment_status === 'on_leave') bg-warning
                        @else bg-secondary @endif">
                                            {{ ucfirst($emp->employment_status) }}
                                        </span>
                                    </td>

                                    {{-- AVAILABILITY --}}
                                    <td>
                                        <span
                                            class="badge 
                        @if ($emp->availability_status === 'available') bg-success
                        @elseif($emp->availability_status === 'on_trip') bg-primary
                        @else bg-danger @endif">
                                            {{ ucfirst(str_replace('_', ' ', $emp->availability_status)) }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2">

                                            {{-- EDIT --}}
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#editEmployeeModal{{ $emp->id }}">
                                                ✏️
                                            </button>

                                            {{-- DELETE --}}
                                            <form action="{{ route('owner.employees.destroy', $emp->id) }}"
                                                method="POST" onsubmit="return confirm('Delete this employee?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger">🗑️</button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>



        <div class="modal fade" id="personDocsModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <form method="POST" action="{{-- {{ route('owner.person-docs.save') }} --}}" enctype="multipart/form-data">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="docsModalTitle">Documents</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <input type="hidden" name="person_id" id="personId">
                            <input type="hidden" name="person_type" id="personTypeDoc">

                            <div class="mb-3">
                                <strong id="driverName"></strong>
                            </div>

                            <hr>

                            {{-- DOCUMENTS --}}
                            <div id="documentsContainer"></div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary">Save</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let currentRole = 'all';

            function getRows() {
                return document.querySelectorAll('tbody tr');
            }

            function applyFilters() {
                const searchInput = document.getElementById('employeeSearch');
                const clearBtn = document.getElementById('clearSearch');

                if (!searchInput || !clearBtn) return;

                const keyword = searchInput.value.toLowerCase();

                getRows().forEach(row => {
                    const role = row.dataset.role;
                    const text = row.innerText.toLowerCase();

                    const matchRole = currentRole === 'all' || role === currentRole;
                    const matchSearch = text.includes(keyword);

                    row.style.display = (matchRole && matchSearch) ? '' : 'none';
                });

                updateSelectAllState();
                toggleClear();
            }

            function toggleClear() {
                const searchInput = document.getElementById('employeeSearch');
                const clearBtn = document.getElementById('clearSearch');

                if (!searchInput || !clearBtn) return;

                clearBtn.style.display = searchInput.value ? 'flex' : 'none';
            }

            function updateSelectAllState() {
                const selectAll = document.getElementById('selectAllEmployees');
                if (!selectAll) return;

                const visible = document.querySelectorAll(
                    'tbody tr:not([style*="display: none"]) .employee-check'
                );

                const checked = document.querySelectorAll(
                    'tbody tr:not([style*="display: none"]) .employee-check:checked'
                );

                selectAll.checked = visible.length && visible.length === checked.length;
                selectAll.indeterminate = checked.length > 0 && checked.length < visible.length;
            }

            // 🔥 EVENT DELEGATION

            document.addEventListener('input', function(e) {
                if (e.target.id === 'employeeSearch') {
                    applyFilters();
                }
            });

            document.addEventListener('click', function(e) {

                // CLEAR SEARCH
                if (e.target.closest('#clearSearch')) {
                    const input = document.getElementById('employeeSearch');
                    if (input) {
                        input.value = '';
                        applyFilters();
                    }
                }

                // FILTER BUTTONS
                if (e.target.closest('#roleFilter button')) {
                    const btn = e.target.closest('button');

                    document.querySelectorAll('#roleFilter button')
                        .forEach(b => b.classList.remove('active'));

                    btn.classList.add('active');
                    currentRole = btn.dataset.role;

                    applyFilters();
                }

                // SELECT ALL
                if (e.target.id === 'selectAllEmployees') {
                    const checked = e.target.checked;

                    document.querySelectorAll('tbody tr:not([style*="display: none"])')
                        .forEach(row => {
                            const cb = row.querySelector('.employee-check');
                            if (cb) cb.checked = checked;
                        });

                    updateSelectAllState();
                }
            });

            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('employee-check')) {
                    updateSelectAllState();
                }
            });

            // initial run
            applyFilters();

        });
    </script>
@endpush

@push('styles')
    <style>
        .ui-searchbox {
            position: relative;
            display: flex;
            align-items: center;
        }

        .ui-searchbox input {
            padding-left: 36px;
            padding-right: 36px;
            /* para may space sa X */
            height: 40px;
            border-radius: 10px;
        }

        /* CLEAR BUTTON */
        .ui-search-clear {
            position: absolute;
            right: 8px;
            background: transparent;
            border: none;
            display: none;
            /* hidden by default */
            align-items: center;
            justify-content: center;
            height: 24px;
            width: 24px;
            border-radius: 50%;
        }

        .ui-search-clear i {
            font-size: 16px;
            color: #98A2B3;
        }

        .ui-search-clear:hover {
            background: #f2f4f7;
        }

        .ui-searchbox i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #98A2B3;
            font-size: 14px;
        }

        /*
                                                                                                                                                |--------------------------------------------------------------------------
                                                                                                                                                | HERO / KPI CARDS
                                                                                                                                                |--------------------------------------------------------------------------
                                                                                                                                                */
        .ui-hero {
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, .05);
            background:
                radial-gradient(900px 500px at 10% 10%, rgba(99, 102, 241, .10), transparent 60%),
                radial-gradient(900px 500px at 90% 20%, rgba(16, 185, 129, .10), transparent 60%),
                linear-gradient(135deg, #fff, #f9fafb);
            box-shadow: 0 20px 40px rgba(17, 24, 39, .06);
        }

        .ui-available-card {
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(16, 24, 40, .06);
            transition: .2s ease;
        }

        .ui-available-card:hover {
            box-shadow: 0 12px 35px rgba(16, 24, 40, .10);
        }

        .ui-available-number {
            font-size: 30px;
            font-weight: 800;
            line-height: 1;
        }


        /*
                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                        | KPI DROPDOWN / EYE BUTTON
                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                        */
        .ui-eye-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid #d0d5dd;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ui-eye-btn:hover {
            background: #f2f4f7;
        }

        .ui-eye-btn i {
            font-size: 16px;
            color: #344054;
        }

        .ui-available-dropdown {
            margin-top: 6px;
        }

        .ui-list-controls .btn {
            border-radius: 999px;
            padding: .25rem .7rem;
        }


        /*
                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                        | PEOPLE HEADER / ACTIONS
                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                        */
        .ui-people-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }

        .ui-people-title-wrap {
            flex: 1 1 auto;
            min-width: 0;
        }

        .ui-people-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ui-people-btn {
            height: 40px;
            border-radius: 12px;
            font-weight: 800;
            padding: 0 14px;
        }

        .ui-people-btn--icon {
            width: 44px;
            padding: 0;
        }


        /*
                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                        | SEARCH BAR
                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                        */
        .ui-people-search {
            position: relative;
            width: 320px;
            max-width: 100%;
        }

        .ui-people-search-input {
            height: 40px;
            border-radius: 12px;
            padding-left: 38px;
            font-weight: 600;
        }

        .ui-people-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #667085;
        }


        /*
                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                        | MOBILE PERSON CARDS
                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                        */
        .ui-mobile-person--centered {
            border-radius: 18px;
            overflow: hidden;
        }

        .ui-person-top {
            display: flex;
            justify-content: center;
            padding-top: 6px;
        }

        .ui-person-avatar-lg {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 10px 25px rgba(16, 24, 40, .10);
        }

        .ui-person-head {
            text-align: center;
            margin-top: 10px;
        }

        .ui-person-name {
            font-weight: 900;
            font-size: 1.05rem;
        }

        .ui-person-email {
            font-size: .88rem;
            color: #667085;
        }


        /*
                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                        | PERSON META
                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                        */
        .ui-person-meta-list {
            margin-top: 14px;
            padding-top: 10px;
            border-top: 1px solid #f1f3f6;
        }

        .ui-meta-line {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
        }

        .ui-meta-line+.ui-meta-line {
            border-top: 1px solid #f7f7f9;
        }

        .ui-meta-label {
            font-size: .72rem;
            font-weight: 600;
            color: #98A2B3;
        }


        /*
                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                        | ACTION BUTTONS
                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                        */
        .ui-person-actions {
            margin-top: 14px;
            display: flex;
            justify-content: center;
            gap: 8px;
        }


        /*
                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                        | RESPONSIVE
                                                                                                                                                                                        |--------------------------------------------------------------------------
                                                                                                                                                                                        */
        @media (max-width: 575.98px) {

            .ui-people-header {
                flex-direction: column;
                align-items: stretch;
            }

            .ui-people-actions {
                width: 100%;
                flex-wrap: wrap;
            }

            .ui-people-search {
                width: 100%;
            }

            .ui-people-btn--add {
                flex: 1 1 auto;
            }
        }
    </style>
@endpush
