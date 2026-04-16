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
                                    {{ $drivers->count() ?? ($stats['total_drivers'] ?? 0) }}
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
                                    {{ $helpers->count() ?? ($stats['total_helpers'] ?? 0) }}
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
                                    {{ $availableDrivers->count() ?? 0 }}
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
                                @forelse($availableDrivers as $dr)
                                    <div class="ui-list-item py-1 small">{{ $dr->name }}</div>
                                @empty
                                    <div class="text-muted small">No available drivers.</div>
                                @endforelse
                            </div>

                            @if (($availableDrivers->count() ?? 0) > 5)
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
                                    {{ $onTripDrivers->count() ?? ($stats['on_trip_drivers'] ?? 0) }}
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
                                @forelse(($onTripDrivers ?? collect()) as $dr)
                                    <div class="ui-list-item py-1 small">{{ $dr->name }}</div>
                                @empty
                                    <div class="text-muted small">No on-trip drivers.</div>
                                @endforelse
                            </div>

                            @if (($onTripDrivers->count() ?? 0) > 5)
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
                                    {{ $availableHelpers->count() ?? 0 }}
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
                                @forelse($availableHelpers as $h)
                                    <div class="ui-list-item py-1 small">{{ $h->name }}</div>
                                @empty
                                    <div class="text-muted small">No available helpers.</div>
                                @endforelse
                            </div>

                            @if (($availableHelpers->count() ?? 0) > 5)
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
                                    {{ $onTripHelpers->count() ?? ($stats['on_trip_helpers'] ?? 0) }}
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

                            @if (($onTripHelpers->count() ?? 0) > 5)
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
                    <div class="ui-people-title-wrap">
                        <h5 class="mb-0 fw-bold ui-people-title">Drivers &amp; Helpers</h5>
                    </div>

                    <div class="ui-people-actions">
                        {{-- Search (Drivers/Helpers) --}}
                        <div class="ui-people-search">
                            <i class="bi bi-search ui-people-search-icon"></i>
                            <input type="text" id="peopleSearchInput" class="form-control ui-people-search-input"
                                placeholder="Search drivers/helpers...">
                        </div>

                        <button class="btn btn-sm btn-primary ui-people-btn ui-people-btn--add" data-bs-toggle="modal"
                            data-bs-target="#addPersonModal">
                            ➕ Add
                        </button>

                        <form id="bulkDeletePeopleForm" method="POST" action="{{-- {{ route('owner.people.bulkDestroy') }} --}}" class="m-0">
                            @csrf
                            @method('DELETE')

                            <input type="hidden" name="driver_ids" id="bulkDriverIds" value="">
                            <input type="hidden" name="helper_ids" id="bulkHelperIds" value="">

                            <button type="submit" class="btn btn-sm btn-outline-danger ui-people-btn ui-people-btn--icon"
                                id="bulkDeletePeopleBtn" disabled onclick="return confirm('Delete selected records?')"
                                title="Delete selected">
                                🗑️
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

                            <form method="POST" id="addPersonForm" action="{{-- {{ route('owner.drivers.store') }} --}}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Type</label>
                                        <select name="type" id="personType" class="form-select" required>
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
                                        <input type="email" name="email" class="form-control"
                                            placeholder="example@email.com">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="active">Active</option>
                                            <option value="on-leave">On Leave</option>
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

                <div class="card-body" style= "padding-right: 0; padding-left: 0; ">

                    {{-- TABS --}}
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-drivers"
                                type="button">
                                <span class="d-inline d-lg-none">👨‍✈️ D</span>
                                <span class="d-none d-lg-inline">👨‍✈️ Drivers</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-helpers" type="button">
                                <span class="d-inline d-lg-none">👷 H</span>
                                <span class="d-none d-lg-inline">👷 Helpers</span>
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">

                        {{-- DRIVERS TAB --}}
                        <div class="tab-pane fade show active" id="tab-drivers">

                            {{-- ✅ MOBILE VIEW (Drivers) --}}
                            <div class="d-block d-lg-none">
                                @forelse($drivers as $driver)
                                    @php
                                        $a = $driver->status;

                                        if ($driver->status === 'inactive') {
                                            $a = 'unavailable';
                                        }

                                        $availabilityLabel = match ($a) {
                                            'on_trip' => 'On Trip',
                                            'inactive' => 'Unavailable',
                                            default => 'Available',
                                        };
                                    @endphp

                                    <div class="card border-0 shadow-sm mb-3 ui-mobile-person ui-mobile-person--centered">
                                        <div class="card-body">

                                            {{-- Avatar --}}
                                            <div class="ui-person-top">
                                                <img src="{{ $driver->profile_photo ? asset('storage/' . $driver->profile_photo) : asset('assets/images/page-img/14.png') }}"
                                                    class="ui-person-avatar-lg" alt="avatar">
                                            </div>

                                            {{-- Name + Email --}}
                                            <div class="ui-person-head">
                                                <div class="ui-person-name">{{ $driver->name }}</div>
                                                <div class="ui-person-email">{{ $driver->email ?? '—' }}</div>
                                            </div>

                                            {{-- Meta (2 columns) --}}
                                            <div class="ui-person-meta-list">

                                                <div class="ui-meta-line">
                                                    <span class="ui-meta-label">Status</span>

                                                    @php
                                                        $displayStatus = $driver->status;
                                                        $badgeClass = 'bg-secondary';
                                                        if ($driver->status === 'active') {
                                                            if ($driver->availability_status === 'on_trip') {
                                                                $displayStatus = 'On Trip';
                                                                $badgeClass = 'bg-warning';
                                                            } elseif ($driver->availability_status === 'on_leave') {
                                                                $displayStatus = 'On Leave';
                                                                $badgeClass = 'bg-info';
                                                            } else {
                                                                $displayStatus = 'Available';
                                                                $badgeClass = 'bg-success';
                                                            }
                                                        } elseif ($driver->status === 'inactive') {
                                                            $displayStatus = 'Inactive';
                                                            $badgeClass = 'bg-secondary';
                                                        } elseif ($driver->status === 'on-leave') {
                                                            $displayStatus = 'On Leave';
                                                            $badgeClass = 'bg-info';
                                                        } elseif ($driver->status === 'on_trip') {
                                                            $displayStatus = 'On Trip';
                                                            $badgeClass = 'bg-warning';
                                                        }
                                                    @endphp

                                                    <span class="badge {{ $badgeClass }}">
                                                        {{ $displayStatus }}
                                                    </span>
                                                </div>

                                                <div class="ui-meta-line">
                                                    <span class="ui-meta-label">Availability</span>

                                                    @php
                                                        $availabilityBadge = match ($a) {
                                                            'on_trip' => 'bg-primary',
                                                            'inactive' => 'bg-danger',
                                                            default => 'bg-success',
                                                        };
                                                    @endphp

                                                    <span class="badge {{ $availabilityBadge }}">
                                                        {{ $availabilityLabel }}
                                                    </span>
                                                </div>

                                            </div>

                                            {{-- Actions --}}
                                            <div class="ui-person-actions">

                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editDriverModal-{{ $driver->id }}">
                                                    ✏️
                                                </button>

                                                <button class="btn btn-sm btn-info driver-docs-btn" data-bs-toggle="modal"
                                                    data-bs-target="#personDocsModal" data-type="driver"
                                                    data-id="{{ $driver->id }}" data-name="{{ $driver->name }}">
                                                    📄
                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                @empty
                                    <div class="text-center py-5">
                                        <div class="text-muted mb-2"><i class="bi bi-person fs-3"></i></div>
                                        <div class="fw-semibold">No drivers found</div>
                                    </div>
                                @endforelse
                            </div>

                            {{-- ✅ DESKTOP/TABLET VIEW --}}
                            <div class="d-none d-lg-block">
                                <div class="table-responsive">
                                    <table class="table table-striped align-middle">
                                        <thead>
                                            <tr>
                                                <th style="width:40px;">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="selectAllDrivers">
                                                </th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Availability</th>
                                                <th style="width: 120px;">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse($drivers as $driver)
                                                @php
                                                    // Status badge
                                                    $statusBadge = 'bg-secondary';
                                                    $statusLabel = ucfirst($driver->status);
                                                    if ($driver->status === 'active') {
                                                        $statusBadge = 'bg-success';
                                                        $statusLabel = 'Active';
                                                    } elseif ($driver->status === 'inactive') {
                                                        $statusBadge = 'bg-secondary';
                                                        $statusLabel = 'Inactive';
                                                    } elseif ($driver->status === 'on-leave') {
                                                        $statusBadge = 'bg-info';
                                                        $statusLabel = 'On Leave';
                                                    } elseif ($driver->status === 'on_trip') {
                                                        $statusBadge = 'bg-warning';
                                                        $statusLabel = 'On Trip';
                                                    }

                                                    // Availability badge
                                                    $availBadge = 'bg-success';
                                                    $availLabel = 'Available';
                                                    if ($driver->availability_status === 'on_trip') {
                                                        $availBadge = 'bg-warning';
                                                        $availLabel = 'On Trip';
                                                    } elseif ($driver->availability_status === 'on_leave') {
                                                        $availBadge = 'bg-info';
                                                        $availLabel = 'On Leave';
                                                    } elseif ($driver->availability_status === 'unavailable') {
                                                        $availBadge = 'bg-danger';
                                                        $availLabel = 'Unavailable';
                                                    }
                                                @endphp

                                                <tr>
                                                    <td>
                                                        <input class="form-check-input driver-check" type="checkbox"
                                                            value="{{ $driver->id }}">
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <img src="{{ $driver->profile_photo ? asset('storage/' . $driver->profile_photo) : asset('assets/images/page-img/14.png') }}"
                                                                style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                                                            <span>{{ $driver->name }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="text-muted">{{ $driver->email ?? '-' }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $statusBadge }}">{{ $statusLabel }}</span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $availBadge }}">{{ $availLabel }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-1">

                                                            {{-- EDIT --}}
                                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                                data-bs-target="#editDriverModal-{{ $driver->id }}">
                                                                ✏️
                                                            </button>

                                                            {{-- DOCUMENTS --}}
                                                            <button class="btn btn-sm btn-info driver-docs-btn"
                                                                data-bs-toggle="modal" data-bs-target="#personDocsModal"
                                                                data-type="driver" data-id="{{ $driver->id }}"
                                                                data-name="{{ $driver->name }}">
                                                                📄
                                                            </button>

                                                        </div>
                                                    </td>
                                                </tr>

                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">No drivers found.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- HELPERS TAB --}}
                        <div class="tab-pane fade" id="tab-helpers">

                            {{-- ✅ MOBILE VIEW (Helpers) --}}
                            <div class="d-block d-lg-none">
                                @forelse($helpers as $helper)
                                    @php
                                        $displayStatus = $helper->status;
                                        $badgeClass = 'bg-secondary';
                                        if ($helper->status === 'active') {
                                            if ($helper->availability_status === 'on_trip') {
                                                $displayStatus = 'On Trip';
                                                $badgeClass = 'bg-warning';
                                            } elseif ($helper->availability_status === 'on_leave') {
                                                $displayStatus = 'On Leave';
                                                $badgeClass = 'bg-info';
                                            } else {
                                                $displayStatus = 'Available';
                                                $badgeClass = 'bg-success';
                                            }
                                        } elseif ($helper->status === 'inactive') {
                                            $displayStatus = 'Inactive';
                                            $badgeClass = 'bg-secondary';
                                        } elseif ($helper->status === 'on-leave') {
                                            $displayStatus = 'On Leave';
                                            $badgeClass = 'bg-info';
                                        } elseif ($helper->status === 'on_trip') {
                                            $displayStatus = 'On Trip';
                                            $badgeClass = 'bg-warning';
                                        }
                                    @endphp

                                    <div class="card border-0 shadow-sm mb-3 ui-mobile-person ui-mobile-person--centered">
                                        <div class="card-body">

                                            {{-- Avatar --}}
                                            <div class="ui-person-top">
                                                <img src="{{ $helper->profile_photo ? asset('storage/' . $helper->profile_photo) : asset('assets/images/page-img/14.png') }}"
                                                    class="ui-person-avatar-lg" alt="avatar">
                                            </div>

                                            {{-- Name + Email --}}
                                            <div class="ui-person-head">
                                                <div class="ui-person-name">{{ $helper->name }}</div>
                                                <div class="ui-person-email">{{ $helper->email ?? '—' }}</div>
                                            </div>

                                            {{-- Meta (2 columns) --}}
                                            <div class="ui-person-meta-list">

                                                <div class="ui-meta-line">
                                                    <span class="ui-meta-label">Status</span>

                                                    <span class="badge {{ $badgeClass }}">
                                                        {{ $displayStatus }}
                                                    </span>
                                                </div>

                                                <div class="ui-meta-line">
                                                    <span class="ui-meta-label">Availability</span>

                                                    <span class="badge {{ $availBadge }}">
                                                        {{ $availLabel }}
                                                    </span>
                                                </div>

                                            </div>

                                            {{-- Actions --}}
                                            <div class="ui-person-actions">
                                                {{-- EDIT --}}
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editHelperModal-{{ $helper->id }}">
                                                    ✏️
                                                </button>

                                                {{-- DOCUMENTS --}}
                                                <button class="btn btn-sm btn-info helper-docs-btn" data-bs-toggle="modal"
                                                    data-bs-target="#personDocsModal" data-type="helper"
                                                    data-id="{{ $helper->id }}" data-name="{{ $helper->name }}">
                                                    📄
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-5">
                                        <div class="text-muted mb-2"><i class="bi bi-person fs-3"></i></div>
                                        <div class="fw-semibold">No helpers found</div>
                                    </div>
                                @endforelse
                            </div>

                            {{-- ✅ DESKTOP/TABLET VIEW --}}
                            <div class="d-none d-lg-block">
                                <div class="table-responsive">
                                    <table class="table table-striped align-middle">
                                        <thead>
                                            <tr>
                                                <th style="width:40px;">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="selectAllHelpers">
                                                </th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Availability</th>
                                                <th style="width: 120px;">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse($helpers as $helper)
                                                @php
                                                    // Status badge
                                                    $statusBadge = 'bg-secondary';
                                                    $statusLabel = ucfirst($helper->status);
                                                    if ($helper->status === 'active') {
                                                        $statusBadge = 'bg-success';
                                                        $statusLabel = 'Active';
                                                    } elseif ($helper->status === 'inactive') {
                                                        $statusBadge = 'bg-secondary';
                                                        $statusLabel = 'Inactive';
                                                    } elseif ($helper->status === 'on-leave') {
                                                        $statusBadge = 'bg-info';
                                                        $statusLabel = 'On Leave';
                                                    } elseif ($helper->status === 'on_trip') {
                                                        $statusBadge = 'bg-warning';
                                                        $statusLabel = 'On Trip';
                                                    }

                                                    // Availability badge
                                                    $availBadge = 'bg-success';
                                                    $availLabel = 'Available';
                                                    if ($helper->availability_status === 'on_trip') {
                                                        $availBadge = 'bg-warning';
                                                        $availLabel = 'On Trip';
                                                    } elseif ($helper->availability_status === 'on_leave') {
                                                        $availBadge = 'bg-info';
                                                        $availLabel = 'On Leave';
                                                    } elseif ($helper->availability_status === 'unavailable') {
                                                        $availBadge = 'bg-danger';
                                                        $availLabel = 'Unavailable';
                                                    }
                                                @endphp

                                                <tr>
                                                    <td>
                                                        <input class="form-check-input helper-check" type="checkbox"
                                                            value="{{ $helper->id }}">
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <img src="{{ $helper->profile_photo ? asset('storage/' . $helper->profile_photo) : asset('assets/images/page-img/14.png') }}"
                                                                style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                                                            <span>{{ $helper->name }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="text-muted">{{ $helper->email ?? '-' }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $statusBadge }}">{{ $statusLabel }}</span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $availBadge }}">{{ $availLabel }}</span>
                                                    </td>

                                                    <td>
                                                        <div class="d-flex gap-1">

                                                            {{-- EDIT --}}
                                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                                data-bs-target="#editHelperModal-{{ $helper->id }}">
                                                                ✏️
                                                            </button>

                                                            {{-- DOCUMENTS --}}
                                                            <button class="btn btn-sm btn-info helper-docs-btn"
                                                                data-bs-toggle="modal" data-bs-target="#personDocsModal"
                                                                data-type="helper" data-id="{{ $helper->id }}"
                                                                data-name="{{ $helper->name }}">
                                                                📄
                                                            </button>

                                                        </div>
                                                    </td>

                                                </tr>

                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">No helpers found.
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
            </div>
        </div>

        {{-- ================= EDIT DRIVER MODALS ================= --}}
        @foreach ($drivers as $driver)
            <div class="modal fade" id="editDriverModal-{{ $driver->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Edit Driver</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form method="POST" action="{{ route('owner.drivers.update', $driver->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="modal-body">
                                <div class="mb-3 text-center">
                                    <label class="form-label d-block">Profile Picture</label>

                                    {{-- CURRENT IMAGE --}}
                                    <div class="mb-2">
                                        @if ($driver->profile_photo)
                                            <img src="{{ asset('storage/' . $driver->profile_photo) }}" alt="Profile"
                                                class="rounded-circle border"
                                                style="width: 200px; height: 200px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center border"
                                                style="width: 200px; height: 200px;">
                                                <span class="text-muted small">No Image</span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- FILE INPUT --}}
                                    <label class="form-label">Change Profile Picture</label>
                                    <input type="file" name="profile_photo" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input class="form-control" name="name" value="{{ $driver->name }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ $driver->email }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="active" {{ $driver->status === 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="on-leave" {{ $driver->status === 'on-leave' ? 'selected' : '' }}>On
                                            Leave</option>
                                        <option value="inactive" {{ $driver->status === 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
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

        {{-- ================= EDIT HELPER MODALS ================= --}}
        @foreach ($helpers as $helper)
            <div class="modal fade" id="editHelperModal-{{ $helper->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Edit Helper</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form method="POST" action="{{ route('owner.helpers.update', $helper->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="modal-body">
                                <div class="mb-3 text-center">
                                    <label class="form-label d-block">Profile Picture</label>

                                    {{-- CURRENT IMAGE --}}
                                    <div class="mb-2">
                                        @if ($helper->profile_photo)
                                            <img src="{{ asset('storage/' . $helper->profile_photo) }}" alt="Profile"
                                                class="rounded-circle border"
                                                style="width: 200px; height: 200px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center border"
                                                style="width: 200px; height: 200px;">
                                                <span class="text-muted small">No Image</span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- FILE INPUT --}}
                                    <label class="form-label">Change Profile Picture</label>
                                    <input type="file" name="profile_photo" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input class="form-control" name="name" value="{{ $helper->name }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ $helper->email }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="active" {{ $helper->status === 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="on-leave" {{ $helper->status === 'on-leave' ? 'selected' : '' }}>On
                                            Leave</option>
                                        <option value="inactive" {{ $helper->status === 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
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
        document.addEventListener('DOMContentLoaded', () => {

            /*
            |--------------------------------------------------------------------------
            | ADD PERSON MODAL ACTION SWITCH
            |--------------------------------------------------------------------------
            */
            const addPersonForm = document.getElementById('addPersonForm');
            const personType = document.getElementById('personType');

            if (addPersonForm && personType) {
                const defaultAction = addPersonForm.getAttribute('action') || '';

                const setFormAction = () => {
                    const type = (personType.value || '').toLowerCase();
                    addPersonForm.action = actions[type] || defaultAction;
                    return !!actions[type];
                };

                setFormAction();

                personType.addEventListener('change', setFormAction);

                addPersonForm.addEventListener('submit', (e) => {
                    if (!setFormAction()) {
                        e.preventDefault();
                        alert('Please select a type (Driver / Helper).');
                        personType.focus();
                    }
                });
            }


            /*
            |--------------------------------------------------------------------------
            | KPI EYE BUTTON COLLAPSE TOGGLE
            |--------------------------------------------------------------------------
            */
            document.querySelectorAll('.ui-eye-btn[data-bs-target]').forEach((btn) => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();

                    const selector = btn.dataset.bsTarget;
                    const target = document.querySelector(selector);

                    if (!target) return;

                    const collapse = bootstrap.Collapse.getOrCreateInstance(target, {
                        toggle: false
                    });

                    const isOpen = target.classList.contains('show');

                    isOpen ? collapse.hide() : collapse.show();

                    btn.setAttribute('aria-expanded', !isOpen);
                });
            });


            /*
            |--------------------------------------------------------------------------
            | BULK DELETE CHECKBOX SYSTEM
            |--------------------------------------------------------------------------
            */
            const bulkBtn = document.getElementById('bulkDeletePeopleBtn');
            const bulkDriverIds = document.getElementById('bulkDriverIds');
            const bulkHelperIds = document.getElementById('bulkHelperIds');

            const selectAllDrivers = document.getElementById('selectAllDrivers');
            const selectAllHelpers = document.getElementById('selectAllHelpers');

            const getDriverChecks = () => [...document.querySelectorAll('.driver-check')];
            const getHelperChecks = () => [...document.querySelectorAll('.helper-check')];

            const refreshBulkUI = () => {
                const selectedDrivers = getDriverChecks().filter(c => c.checked).map(c => c.value);
                const selectedHelpers = getHelperChecks().filter(c => c.checked).map(c => c.value);

                bulkDriverIds.value = selectedDrivers.join(',');
                bulkHelperIds.value = selectedHelpers.join(',');

                bulkBtn.disabled = (selectedDrivers.length + selectedHelpers.length) === 0;

                if (selectAllDrivers) {
                    selectAllDrivers.checked =
                        selectedDrivers.length > 0 &&
                        selectedDrivers.length === getDriverChecks().length;
                }

                if (selectAllHelpers) {
                    selectAllHelpers.checked =
                        selectedHelpers.length > 0 &&
                        selectedHelpers.length === getHelperChecks().length;
                }
            };

            selectAllDrivers?.addEventListener('change', () => {
                getDriverChecks().forEach(c => c.checked = selectAllDrivers.checked);
                refreshBulkUI();
            });

            selectAllHelpers?.addEventListener('change', () => {
                getHelperChecks().forEach(c => c.checked = selectAllHelpers.checked);
                refreshBulkUI();
            });

            document.addEventListener('change', (e) => {
                if (
                    e.target.classList.contains('driver-check') ||
                    e.target.classList.contains('helper-check')
                ) {
                    refreshBulkUI();
                }
            });

            refreshBulkUI();


            /*
            |--------------------------------------------------------------------------
            | REMEMBER ACTIVE TAB
            |--------------------------------------------------------------------------
            */
            const TAB_KEY = 'driversCrewActiveTab';

            document.querySelectorAll('button[data-bs-toggle="tab"]').forEach((tabBtn) => {
                tabBtn.addEventListener('shown.bs.tab', (e) => {
                    localStorage.setItem(TAB_KEY, e.target.dataset.bsTarget);
                });
            });

            const savedTab = localStorage.getItem(TAB_KEY);

            if (savedTab) {
                const btn = document.querySelector(`button[data-bs-target="${savedTab}"]`);
                if (btn) bootstrap.Tab.getOrCreateInstance(btn).show();
            }


            /*
            |--------------------------------------------------------------------------
            | SEARCH FILTER
            |--------------------------------------------------------------------------
            */
            const searchInput = document.getElementById('peopleSearchInput');

            const normalize = str => (str || '').toLowerCase().trim();

            const filterActivePane = () => {
                const query = normalize(searchInput?.value);

                const activeTabBtn = document.querySelector('button[data-bs-toggle="tab"].active');
                const targetSelector = activeTabBtn?.dataset.bsTarget || '#tab-drivers';
                const pane = document.querySelector(targetSelector);

                if (!pane) return;

                pane.querySelectorAll('tbody tr, .ui-mobile-person').forEach((el) => {
                    el.style.display = normalize(el.innerText).includes(query) ? '' : 'none';
                });
            };

            searchInput?.addEventListener('input', filterActivePane);

            document.querySelectorAll('button[data-bs-toggle="tab"]').forEach((tabBtn) => {
                tabBtn.addEventListener('shown.bs.tab', filterActivePane);
            });

        });
    </script>
@endpush

@push('styles')
    <style>
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
