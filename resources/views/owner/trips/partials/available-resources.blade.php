{{-- Available Resources --}}

@php
    $availableTrucks = $availableTrucks ?? collect();
    $availableDrivers = $availableDrivers ?? collect();
    $availableHelpers = $availableHelpers ?? collect();
@endphp


<div class="row g-3 mb-1">

    {{-- AVAILABLE TRUCKS --}}
    <div class="col-12 col-md-4">
        <div class="card ui-available-card border-bottom border-4 border-0 border-primary" style="margin-bottom:10px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small fw-semibold">Available Trucks 🚚</div>

                    <div class="d-flex align-items-center gap-3 flex-shrink-0">
                        <div class="ui-available-number text-primary">{{ $availableTrucks->count() }}</div>

                        <button type="button" class="btn btn-sm ui-eye-btn collapse-toggle"
                            data-target="#availTrucksList">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="collapse mt-0 ui-available-dropdown" id="availTrucksList">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-2">
                    <div class="ui-paginated-list" data-per-page="5" data-target="trucks">
                        @forelse($availableTrucks as $t)
                            <div class="ui-list-item py-1 small">
                                {{ $t->plate_number }}
                                @if ($t->truck_type)
                                    <span class="text-muted">({{ $t->truck_type }})</span>
                                @endif
                            </div>
                        @empty
                            <div class="text-muted small">No available trucks.</div>
                        @endforelse
                    </div>

                    @if ($availableTrucks->count() > 5)
                        <div class="d-flex justify-content-end align-items-center gap-2 mt-2 ui-list-controls"
                            data-controls="trucks">
                            <button type="button" class="btn btn-sm btn-light ui-list-prev">Prev</button>
                            <div class="small text-muted ui-list-page">1</div>
                            <button type="button" class="btn btn-sm btn-light ui-list-next">Next</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- AVAILABLE DRIVERS --}}
    <div class="col-12 col-md-4">
        <div class="card ui-available-card border-bottom border-4 border-0 border-success" style="margin-bottom:10px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small fw-semibold">Available Drivers 👤</div>

                    <div class="d-flex align-items-center gap-3 flex-shrink-0">
                        <div class="ui-available-number text-success">{{ $availableDrivers->count() }}</div>

                        <button type="button" class="btn btn-sm ui-eye-btn collapse-toggle"
                            data-target="#availDriversList">
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

                    @if ($availableDrivers->count() > 5)
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

    {{-- AVAILABLE HELPERS --}}
    <div class="col-12 col-md-4">
        <div class="card ui-available-card border-bottom border-4 border-0 border-warning" style="margin-bottom:10px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small fw-semibold">Available Helpers 👷</div>

                    <div class="d-flex align-items-center gap-3 flex-shrink-0">
                        <div class="ui-available-number text-warning">{{ $availableHelpers->count() }}</div>

                        <button type="button" class="btn btn-sm ui-eye-btn collapse-toggle"
                            data-target="#availHelpersList">
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

                    @if ($availableHelpers->count() > 5)
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

</div>
