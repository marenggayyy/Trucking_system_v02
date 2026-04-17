@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif


@extends('layouts.owner')

@section('title', 'Trucks')

@section('content')

    <div class="container-fluid py-4">

        {{-- Header (TEAM UI HERO) --}}
        <div class="ui-hero p-4 mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">

                <div>
                    <h4 class="mb-1 fw-bold">Trucks</h4>
                    <div class="text-muted small">
                        Fleet visibility — availability, condition, and cost.
                    </div>
                </div>

                {{-- removed search + new trip here (moved inside table card) --}}

            </div>
        </div>

        {{-- Fleet Summary (Indicators) --}}
        <div class="row g-3 mb-1">
            <div class="col-6 col-md-3">
                <div class="card ui-card border-0 ui-indicator ui-kpi-card w-100">
                    <div class="card-body text-center ui-kpi-body">
                        <div class="ui-kpi-label">Total Trucks</div>
                        <div class="ui-kpi-number" style="padding-top: 20px;">{{ $stats['total'] ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card ui-card border-0 ui-indicator ui-kpi-card w-100">
                    <div class="card-body text-center ui-kpi-body ">
                        <div class="ui-kpi-label">Available</div>
                        <div class="ui-kpi-number text-success" style="padding-top: 20px;">{{ $stats['available'] ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card ui-card border-0 ui-indicator ui-kpi-card w-100">
                    <div class="card-body text-center ui-kpi-body">
                        <div class="ui-kpi-label">On Trip</div>
                        <div class="ui-kpi-number text-primary" style="padding-top: 20px;">{{ $stats['on_trip'] ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card ui-card border-0 ui-indicator ui-kpi-card w-100">
                    <div class="card-body text-center ui-kpi-body">
                        <div class="ui-kpi-label">Out of Service</div>
                        <div class="ui-kpi-number text-danger" style="padding-top: 20px;">
                            {{ $stats['out_of_service'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CREATE TRUCK MODAL --}}
        <div class="modal fade" id="createTruckModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content border-0 shadow">

                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold">Add Truck</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="{{ route('owner.trucks.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Company</label>
                                <select class="form-select" name="company_id" required>
                                    <option value="" disabled selected>Select company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Plate Number</label>
                                <input class="form-control" name="plate_number" placeholder="e.g. ABC-1234" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Truck Type</label>
                                <select class="form-select" name="truck_type" required>
                                    <option value="" disabled selected>Select type</option>
                                    <option value="L300">L300</option>
                                    <option value="6W">6W</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select class="form-select" name="status">
                                    <option value="available">Available</option>
                                    <option value="on_trip">On Trip</option>
                                    <option value="on_maintenance">On Maintenance</option>
                                    <option value="unavailable">Unavailable</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-outline-secondary ui-pill-btn"
                                    data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button class="btn btn-primary ui-pill-btn">Save Truck</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        {{-- Truck List --}}
        <div class="card ui-card border-0">
            <div class="card-header bg-transparent border-0 pb-0">
                <div
                    class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
                    <div>
                        <h6 class="mb-0 fw-semibold">Registered Trucks</h6>
                        <div class="text-muted small mt-1">Manage your fleet records by type.</div>
                    </div>

                    <div class="ui-header-actions ms-lg-auto">

                        <button class="btn btn-primary ui-pill-btn ui-btn-equal" data-bs-toggle="modal"
                            data-bs-target="#createTruckModal">
                            <i class="bi bi-plus-lg me-1"></i> Add Truck
                        </button>

                        <button class="btn btn-danger ui-pill-btn ui-btn-equal" data-bs-toggle="modal"
                            data-bs-target="#deleteAllTrucksModal" {{ ($stats['total'] ?? 0) == 0 ? 'disabled' : '' }}>
                            <i class="bi bi-trash3 me-1"></i> Delete All
                        </button>

                    </div>
                </div>
                {{-- 
                <div class="ui-divider mt-3"></div> --}}
            </div>

            <div class="card-body pt-3">

                <div class="row g-3">
                    {{-- ================= 6W COLUMN ================= --}}
                    <div class="col-12 col-lg-6">

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-none d-lg-block">
                                    <span class="ui-section-pill">
                                        <i class="bi bi-truck-front me-1"></i> 6W
                                    </span>
                                </div>

                                <div class="d-flex align-items-center gap-2 ms-auto">
                                    <div class="d-none d-lg-block">
                                        <button type="button"
                                            class="btn btn-outline-danger btn-sm ui-pill-btn ui-btn-equal"
                                            data-bs-toggle="modal" data-bs-target="#deleteAll6WModal"
                                            {{ ($sixWTrucks->count() ?? 0) == 0 ? 'disabled' : '' }}>
                                            <i class="bi bi-trash3 me-1"></i> Delete All
                                        </button>
                                    </div>
                                    <span class="text-muted small">
                                        Total: <strong>{{ $sixWTrucks->count() }}</strong>
                                    </span>
                                </div>
                            </div>

                        </div>
                        {{-- DESKTOP / TABLET --}}
                        <div class="d-none d-lg-block">
                            <div class="ui-table-wrap">
                                <div class="ui-table-scroll">
                                    <table class="table ui-table align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th>Plate Number</th>
                                                <th>Status</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse($sixWTrucks as $truck)
                                                @php $status = $truck->status; @endphp

                                                <tr>
                                                    <td class="fw-semibold">{{ $truck->plate_number }}</td>

                                                    <td>
                                                        <span
                                                            class="ui-badge 
                                                                {{ $status === 'available' ? 'ui-badge-completed' : '' }}
                                                                {{ $status === 'on_trip' ? 'ui-badge-primary' : '' }}
                                                                {{ $status === 'on_maintenance' ? 'ui-badge-warning' : '' }}
                                                                {{ $status === 'unavailable' ? 'ui-badge-cancelled' : '' }} ">
                                                            <span
                                                                class="ui-dot 
                                                                    {{ $status === 'available' ? 'ui-dot-completed' : '' }}
                                                                    {{ $status === 'on_trip' ? 'ui-dot-dispatched' : '' }}
                                                                    {{ $status === 'on_maintenance' ? 'ui-dot-warning' : '' }}
                                                                    {{ $status === 'unavailable' ? 'ui-dot-cancelled' : '' }}
                                                                "></span>

                                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                                        </span>
                                                    </td>

                                                    <td class="text-end">
                                                        <div class="d-inline-flex gap-2">
                                                            <button class="btn btn-sm btn-warning ui-icon-btn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editTruckModal-6w-{{ $truck->id }}"
                                                                title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>

                                                            <button type="button"
                                                                class="btn btn-sm ui-icon-btn btn-danger"
                                                                onclick="openDeleteModal({{ $truck->id }})">
                                                                <i class="bi bi-trash3"></i>
                                                            </button>

                                                            <button class="btn btn-sm btn-info ui-icon-btn"
                                                                title="View Details"
                                                                onclick="openSidebar({{ $truck->id }})">
                                                                <i class="bi bi-eye"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted py-4">
                                                        No 6W trucks registered.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>


                    {{-- ================= L300 COLUMN ================= --}}
                    <div class="col-12 col-lg-6">

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-none d-lg-block">
                                    <span class="ui-section-pill">
                                        <i class="bi bi-truck me-1"></i> L300 - AUV
                                    </span>
                                    <strong>{{ $l300Trucks->count() }}</strong>
                                </div>

                                <div class="d-flex align-items-center gap-2 ms-auto">
                                    <div class="d-none d-lg-block">
                                        <button type="button"
                                            class="btn btn-outline-danger btn-sm ui-pill-btn ui-btn-equal"
                                            data-bs-toggle="modal" data-bs-target="#deleteAllL300Modal"
                                            {{ ($l300Trucks->count() ?? 0) == 0 ? 'disabled' : '' }}>
                                            <i class="bi bi-trash3 me-1"></i> Delete All
                                        </button>
                                    </div>
                                    <span class="text-muted small">
                                        Total: <strong>{{ $l300Trucks->count() }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- DESKTOP / TABLET --}}
                        <div class="d-none d-lg-block">
                            <div class="ui-table-wrap">
                                <div class="ui-table-scroll">
                                    <table class="table ui-table align-middle mb-0">

                                        <thead>
                                            <tr>
                                                <th>Plate Number</th>
                                                <th>Status</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse($l300Trucks as $truck)
                                                @php $status = $truck->status; @endphp

                                                <tr>
                                                    <td class="fw-semibold">{{ $truck->plate_number }}</td>

                                                    <td>
                                                        <span
                                                            class="ui-badge 
                                                                {{ $status === 'available' ? 'ui-badge-completed' : '' }}
                                                                {{ $status === 'on_trip' ? 'ui-badge-primary' : '' }}
                                                                {{ $status === 'on_maintenance' ? 'ui-badge-warning' : '' }}
                                                                {{ $status === 'unavailable' ? 'ui-badge-cancelled' : '' }}">
                                                            <span
                                                                class="ui-dot 
                                                                    {{ $status === 'available' ? 'ui-dot-completed' : '' }}
                                                                    {{ $status === 'on_trip' ? 'ui-dot-dispatched' : '' }}
                                                                    {{ $status === 'on_maintenance' ? 'ui-dot-warning' : '' }}
                                                                    {{ $status === 'unavailable' ? 'ui-dot-cancelled' : '' }}
                                                                ">
                                                            </span>

                                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                                        </span>
                                                    </td>

                                                    <td class="text-end">
                                                        <div class="d-inline-flex gap-2">
                                                            <button class="btn btn-sm btn-warning ui-icon-btn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editTruckModal-l300-{{ $truck->id }}"
                                                                title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>

                                                            <button type="button"
                                                                class="btn btn-sm ui-icon-btn btn-danger"
                                                                onclick="openDeleteModal({{ $truck->id }})">
                                                                <i class="bi bi-trash3"></i>
                                                            </button>

                                                            <button class="btn btn-sm btn-info ui-icon-btn"
                                                                title="View Details"
                                                                onclick="openSidebar({{ $truck->id }})">
                                                                <i class="bi bi-eye"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted py-4">
                                                        No L300 trucks registered.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                {{-- MOBILE --}}
                <div class="d-block d-lg-none">

                    {{-- 6W --}}
                    @forelse($sixWTrucks as $truck)
                        @php $status = $truck->status; @endphp

                        <div class="card border-0 shadow-sm mb-3 ui-mobile-truck">
                            <div class="card-body">

                                {{-- HEADER --}}
                                <div class="ui-truck-header">
                                    <div class="ui-truck-name">
                                        {{ $truck->plate_number }}
                                    </div>

                                    <div class="ui-truck-type type-6w">
                                        6W
                                    </div>
                                </div>

                                {{-- META --}}
                                <div class="mt-3 ui-truck-meta">
                                    <div class="ui-truck-row">
                                        <span class="ui-truck-label">Status</span>
                                        <span class="ui-truck-value">
                                            <span
                                                class="ui-dot 
                                                    {{ $status === 'available' ? 'ui-dot-completed' : '' }}
                                                    {{ $status === 'on_trip' ? 'ui-dot-dispatched' : '' }}
                                                    {{ $status === 'on_maintenance' ? 'ui-dot-warning' : '' }}
                                                    {{ $status === 'unavailable' ? 'ui-dot-cancelled' : '' }}
                                                ">
                                            </span>
                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </span>
                                    </div>
                                </div>

                                {{-- ACTIONS --}}
                                {{-- ACTIONS --}}
                                <div class="mt-3 d-flex justify-content-end gap-2 ui-mobile-actions">

                                    <button class="btn btn-sm btn-warning ui-icon-btn" data-bs-toggle="modal"
                                        data-bs-target="#editTruckModal-6w-{{ $truck->id }}" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <button type="button" class="btn btn-sm ui-icon-btn btn-danger"
                                        onclick="openDeleteModal({{ $truck->id }})">
                                        <i class="bi bi-trash3"></i>
                                    </button>

                                    <button class="btn btn-sm btn-info ui-icon-btn" title="View Details"
                                        onclick="openSidebar({{ $truck->id }})">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            No 6W trucks registered.
                        </div>
                    @endforelse


                    {{-- L300 --}}
                    @forelse($l300Trucks as $truck)
                        @php $status = $truck->status; @endphp

                        <div class="card border-0 shadow-sm mb-3 ui-mobile-truck">
                            <div class="card-body">

                                {{-- HEADER --}}
                                <div class="ui-truck-header">
                                    <div class="ui-truck-name">
                                        {{ $truck->plate_number }}
                                    </div>

                                    <div class="ui-truck-type type-l300">
                                        L300
                                    </div>
                                </div>

                                {{-- META --}}
                                <div class="mt-3 ui-truck-meta">
                                    <div class="ui-truck-row">
                                        <span class="ui-truck-label">Status</span>
                                        <span class="ui-truck-value">
                                            <span
                                                class="ui-dot 
                                                    {{ $status === 'available' ? 'ui-dot-completed' : '' }}
                                                    {{ $status === 'on_trip' ? 'ui-dot-dispatched' : '' }}
                                                    {{ $status === 'on_maintenance' ? 'ui-dot-warning' : '' }}
                                                    {{ $status === 'unavailable' ? 'ui-dot-cancelled' : '' }} ">
                                            </span>

                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </span>
                                    </div>
                                </div>

                                {{-- ACTIONS --}}
                                <div class="mt-3 d-flex justify-content-end gap-2 ui-mobile-actions">

                                    <button class="btn btn-sm btn-warning ui-icon-btn" data-bs-toggle="modal"
                                        data-bs-target="#editTruckModal-l300-{{ $truck->id }}" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <button type="button" class="btn btn-sm ui-icon-btn btn-danger"
                                        onclick="openDeleteModal({{ $truck->id }})">
                                        <i class="bi bi-trash3"></i>
                                    </button>

                                    <button class="btn btn-sm btn-info ui-icon-btn" title="View Details"
                                        onclick="openSidebar({{ $truck->id }})">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            No L300 trucks registered.
                        </div>
                    @endforelse

                </div>

            </div>
        </div>
    </div>

    {{-- EDIT MODAL (6W) --}}
    @foreach ($sixWTrucks as $truck)
        <div class="modal fade" id="editTruckModal-6w-{{ $truck->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold">Edit Truck</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="{{ route('owner.trucks.update', $truck->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Company</label>
                                <select class="form-select" name="company_id" required>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $truck->company_id == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Plate
                                    Number</label>
                                <input class="form-control" name="plate_number" value="{{ $truck->plate_number }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Truck
                                    Type</label>
                                <select class="form-select" name="truck_type" required>
                                    <option value="L300" {{ $truck->truck_type === 'L300' ? 'selected' : '' }}>
                                        L300</option>
                                    <option value="6W" {{ $truck->truck_type === '6W' ? 'selected' : '' }}>
                                        6W</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select class="form-select" name="status">
                                    <option value="available" {{ $truck->status === 'available' ? 'selected' : '' }}>
                                        Available</option>
                                    <option value="on_trip" {{ $truck->status === 'on_trip' ? 'selected' : '' }}>On Trip
                                    </option>
                                    <option value="on_maintenance"
                                        {{ $truck->status === 'on_maintenance' ? 'selected' : '' }}>On Maintenance</option>
                                    <option value="unavailable" {{ $truck->status === 'unavailable' ? 'selected' : '' }}>
                                        Unavailable</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-outline-secondary ui-pill-btn"
                                    data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button class="btn btn-primary ui-pill-btn">Save
                                    Changes</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endforeach

    {{-- EDIT MODAL (L300) --}}
    @foreach ($l300Trucks as $truck)
        <div class="modal fade" id="editTruckModal-l300-{{ $truck->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold">Edit Truck</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="{{ route('owner.trucks.update', $truck->id) }}">
                            @csrf
                            @method('PUT')


                            <div class="mb-3">
                                <label class="form-label fw-semibold">Company</label>
                                <select class="form-select" name="company_id" required>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $truck->company_id == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Plate
                                    Number</label>
                                <input class="form-control" name="plate_number" value="{{ $truck->plate_number }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Truck
                                    Type</label>
                                <select class="form-select" name="truck_type" required>
                                    <option value="L300" {{ $truck->truck_type === 'L300' ? 'selected' : '' }}>
                                        L300</option>
                                    <option value="6W" {{ $truck->truck_type === '6W' ? 'selected' : '' }}>
                                        6W</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select class="form-select" name="status">
                                    <option value="available" {{ $truck->status === 'available' ? 'selected' : '' }}>
                                        Available</option>
                                    <option value="on_trip" {{ $truck->status === 'on_trip' ? 'selected' : '' }}>On Trip
                                    </option>
                                    <option value="on_maintenance"
                                        {{ $truck->status === 'on_maintenance' ? 'selected' : '' }}>On Maintenance</option>
                                    <option value="unavailable" {{ $truck->status === 'unavailable' ? 'selected' : '' }}>
                                        Unavailable</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-outline-secondary ui-pill-btn"
                                    data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button class="btn btn-primary ui-pill-btn">Save
                                    Changes</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endforeach

    {{-- DELETE ALL L300 MODAL --}}
    <div class="modal fade" id="deleteAllL300Modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h6 class="modal-title fw-bold">Delete All L300 Trucks</h6>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    Are you sure you want to delete <strong>ALL L300</strong> trucks?
                    <div class="text-muted small mt-2">This action cannot be undone.</div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline-secondary ui-pill-btn" data-bs-dismiss="modal">Cancel</button>

                    <form method="POST" action="{{ route('owner.trucks.destroyAll') }}">
                        @csrf
                        <input type="hidden" name="truck_type" value="L300">

                        <button type="submit" class="btn btn-danger ui-pill-btn">
                            Yes, Delete All
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- DELETE ALL 6W MODAL --}}
    <div class="modal fade" id="deleteAll6WModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h6 class="modal-title fw-bold">Delete All 6W Trucks</h6>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    Are you sure you want to delete <strong>ALL 6W</strong> trucks?
                    <div class="text-muted small mt-2">This action cannot be undone.</div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline-secondary ui-pill-btn" data-bs-dismiss="modal">Cancel</button>

                    <form method="POST" action="{{ route('owner.trucks.destroyAll') }}">
                        @csrf
                        <input type="hidden" name="truck_type" value="6W">

                        <button type="submit" class="btn btn-danger ui-pill-btn">
                            Yes, Delete All
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- DELETE ALL TRUCKS (GLOBAL - MOBILE) --}}
    <div class="modal fade" id="deleteAllTrucksModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header bg-light">
                    <h6 class="modal-title fw-bold text-danger">
                        Delete ALL Trucks
                    </h6>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    This will permanently delete
                    <strong>ALL trucks (6W & L300)</strong>.
                    <div class="text-muted small mt-2">
                        This action cannot be undone.
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline-secondary ui-pill-btn" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <form method="POST" action="{{ route('owner.trucks.destroyAll') }}">
                        @csrf

                        <button type="submit" class="btn btn-danger ui-pill-btn">
                            Yes, Delete Everything
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- DELETE ONE ON ONE --}}

    <div class="modal fade" id="deleteTruckModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-header bg-light">
                    <h6 class="modal-title fw-bold text-danger">Delete Truck</h6>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    Are you sure you want to delete this truck?
                    <div class="text-muted small mt-2">
                        This action cannot be undone.
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-outline-secondary ui-pill-btn" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <form method="POST" id="deleteTruckForm">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger ui-pill-btn">
                            Yes, Delete
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>


@endsection



@push('scripts')
    <script>
        function openSidebar(truckId) {
            const overlay = document.getElementById('sidebarOverlay');
            const sidebar = document.getElementById('truckSidebar');
            const content = document.getElementById('truckSidebarContent');

            overlay.style.display = 'block';
            sidebar.classList.add('active');

            content.innerHTML = `
        <div class="p-4 text-center text-muted">
            Loading...
        </div>
    `;

            fetch(`/owner/trucks/sidebar/${truckId}`)
                .then(response => response.text())
                .then(html => {
                    content.innerHTML = html;
                })
                .catch(() => {
                    content.innerHTML = `
                <div class="p-4 text-danger text-center">
                    Failed to load truck details.
                </div>
            `;
                });
        }

        function closeSidebar() {
            document.getElementById('sidebarOverlay').style.display = 'none';
            document.getElementById('truckSidebar').classList.remove('active');
        }

        function openDeleteModal(truckId) {
            const form = document.getElementById('deleteTruckForm');
            form.action = `/owner/trucks/${truckId}`;

            const modal = new bootstrap.Modal(document.getElementById('deleteTruckModal'));
            modal.show();
        }
    </script>

    <div id="sidebarOverlay" onclick="closeSidebar()"></div>

    <div id="truckSidebar">
        <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
            <h5 class="mb-0 fw-bold">Truck Details</h5>
            <button class="btn btn-sm btn-outline-secondary" onclick="closeSidebar()">
                &times;
            </button>
        </div>

        <div id="truckSidebarContent" class="flex-grow-1"></div>
    </div>
@endpush

@push('styles')
    <style>
        .ui-badge-warning {
            background: #fff7e6;
            color: #b54708;
            border-color: #fedf89;
        }

        .ui-dot-warning {
            background: #f79009;
        }

        /* =========================================================
                                                    CORE UI
                                                 ========================================================= */
        .ui-card {
            border-radius: 18px;
            box-shadow: 0 14px 40px rgba(16, 24, 40, .08);
            transition: all .25s ease;
        }

        .ui-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 50px rgba(16, 24, 40, .12);
        }

        .ui-hero {
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, .05);
            background:
                radial-gradient(900px 500px at 10% 10%, rgba(99, 102, 241, .10), transparent 60%),
                radial-gradient(900px 500px at 90% 20%, rgba(16, 185, 129, .10), transparent 60%),
                linear-gradient(135deg, #ffffff, #f9fafb);
            box-shadow: 0 20px 40px rgba(17, 24, 39, .06);
        }

        .ui-divider {
            height: 1px;
            width: 100%;
            background: #edf0f4;
        }


        /* =========================================================
                                                    BUTTONS
                                                ========================================================= */
        .ui-pill-btn {
            border-radius: 999px;
            padding: .45rem .9rem;
        }

        .ui-btn-equal,
        .ui-btn-wide {
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 1.1rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .ui-btn-wide {
            min-width: 140px;
        }


        /* =========================================================
                                                                        KPI CARDS
                                                                    ========================================================= */
        .ui-kpi-card .card-body {
            padding: 25px 10px;
        }

        .ui-kpi-label {
            font-size: .9rem;
            font-weight: 600;
            color: #667085;
        }

        .ui-kpi-number {
            font-size: 1.9rem;
            font-weight: 800;
            line-height: 1.1;
        }

        @media(min-width:992px) {
            .ui-kpi-number {
                font-size: 2.2rem;
            }
        }


        /* =========================================================
                                                                        INDICATORS
                                                                    ========================================================= */
        .ui-indicator {
            position: relative;
            overflow: hidden;
        }

        .ui-indicator::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            border-radius: 18px 18px 0 0;
        }

        .ui-indicator-neutral::before {
            background: #94a3b8;
        }

        .ui-indicator-primary::before {
            background: #0d6efd;
        }

        .ui-indicator-success::before {
            background: #198754;
        }

        .ui-indicator-warning::before {
            background: #ffc107;
        }

        .ui-indicator-danger::before {
            background: #dc3545;
        }


        /* =========================================================
                                                                       TABLES
                                                                    ========================================================= */
        .ui-table-wrap {
            border: 1px solid #edf0f4;
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
        }

        .ui-table-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .ui-table {
            min-width: 520px;
        }

        .ui-table thead th {
            background: #f8fafc;
            color: #667085;
            font-weight: 600;
            font-size: .8rem;
            letter-spacing: .02em;
            padding: 14px 16px;
            white-space: nowrap;
            border-bottom: 1px solid #edf0f4 !important;
        }

        .ui-table tbody td {
            padding: 14px 16px;
            border-top: 1px solid #f1f3f6 !important;
            vertical-align: middle;
        }

        .ui-table tbody tr:hover {
            background: #fafcff;
        }

        /* =========================================================
                                                                       BADGES / STATUS
                                                                    ========================================================= */
        .ui-badge {
            display: inline-flex;
            align-items: center;
            padding: .25rem .6rem;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 600;
            border: 1px solid transparent;
        }

        .ui-badge-completed {
            background: #e7f8ef;
            color: #027a48;
            border-color: #bff0d4;
        }

        .ui-badge-cancelled {
            background: #ffeceb;
            color: #b42318;
            border-color: #ffd1cf;
        }

        .ui-badge-primary {
            background: #e8f1ff;
            color: #175cd3;
            border-color: #cfe1ff;
        }

        .ui-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .ui-dot-completed {
            background: #027a48;
        }

        .ui-dot-cancelled {
            background: #b42318;
        }

        .ui-dot-dispatched {
            background: #175cd3;
        }


        /* =========================================================
                                                                       ICON BUTTONS
                                                                    ========================================================= */
        .ui-icon-btn {
            border-radius: 12px;
            border: 1px solid transparent;
            background: #f9fafb;
            padding: .45rem .65rem;
            transition: .2s ease;
        }

        .ui-icon-btn.btn-warning {
            background: #fff7ed;
            color: #b45309;
            border-color: #fde68a;
        }

        .ui-icon-btn.btn-warning:hover {
            background: #ffedd5;
        }

        .ui-icon-btn.btn-info {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .ui-icon-btn.btn-info:hover {
            background: #dbeafe;
        }

        .ui-icon-btn.delete-btn,
        .ui-icon-btn.btn-danger {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }

        .ui-icon-btn.btn-danger:hover {
            background: #fee2e2;
        }


        /* =========================================================
                                                                       SECTION PILLS
                                                                    ========================================================= */
        .ui-section-pill {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            padding: .35rem .75rem;
            border-radius: 999px;
            border: 1px solid #edf0f4;
            background: #fff;
            font-weight: 800;
            font-size: .8rem;
            color: #344054;
        }


        /* =========================================================
                                                                       MOBILE CARDS
                                                                    ========================================================= */
        .ui-mobile-truck {
            border-radius: 16px;
            transition: .2s ease;
        }

        .ui-mobile-truck:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 24, 40, .08);
        }

        .ui-truck-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .ui-truck-name {
            font-weight: 700;
            font-size: 1rem;
            line-height: 1.25;
        }

        .ui-truck-type {
            font-size: .7rem;
            font-weight: 800;
            padding: .25rem .6rem;
            border-radius: 999px;
        }

        .ui-truck-type.type-6w {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .ui-truck-type.type-l300 {
            background: #ecfdf5;
            color: #047857;
        }

        .ui-truck-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border-top: 1px solid #f1f3f6;
        }

        .ui-truck-label {
            color: #98a2b3;
        }

        .ui-truck-value {
            font-weight: 600;
        }


        /* =========================================================
                                                                       HEADER ACTIONS
                                                                    ========================================================= */
        .ui-header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        @media(max-width:767.98px) {
            .ui-header-actions {
                flex-direction: column;
                width: 100%;
                margin-top: 16px;
            }

            .ui-header-actions .btn {
                width: 100%;
            }

            .ui-mobile-actions .ui-icon-btn {
                padding: .5rem .65rem;
                border-radius: 12px;
            }
        }

        @media(min-width:768px) {
            .ui-header-actions {
                flex-direction: row;
            }

            .ui-header-actions .btn {
                min-width: 150px;
            }
        }


        /* =========================================================
                                                                       SIDEBAR
                                                                    ========================================================= */
        #sidebarOverlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .35);
            z-index: 1040;
            display: none;
        }

        #truckSidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: 420px;
            max-width: 100vw;
            height: 100vh;
            background: #fff;
            box-shadow: -4px 0 32px rgba(0, 0, 0, .12);
            z-index: 1050;
            transform: translateX(100%);
            transition: .3s ease;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        #truckSidebar.active {
            transform: translateX(0);
        }

        @media(max-width:600px) {
            #truckSidebar {
                width: 100vw;
            }
        }
    </style>
@endpush
