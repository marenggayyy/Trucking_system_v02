@php
    $trips = $trips ?? collect();
@endphp

<div class="ui-divider mt-3"></div>

<div class="card-body pt-4">

    <div class="row g-3">

        @forelse ($trips as $t)
            <div class="col-12 col-md-6 col-lg-4 col-xl-5col">

                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex flex-column">

                        {{-- HEADER --}}
                        <div class="text-center">
                            <div class="trip-ticket">
                                {{ $t->trip_ticket_no }}
                            </div>

                            <div class="fw-semibold text-muted small">
                                {{ $t->destination->store_name ?? '-' }}
                            </div>

                            {{-- STATUS CHIPS --}}
                            <div class="trip-status-row">

                                <span class="trip-status delivery">
                                    {{ $t->status }}
                                </span>
                            </div>

                        </div>

                        <hr class="my-3">

                        {{-- DETAILS --}}
                        <div class="small">

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Date:</span>
                                <span class="fw-semibold">
                                    {{ \Carbon\Carbon::parse($t->dispatch_date)->format('d/m') }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Truck:</span>
                                <span class="fw-semibold">
                                    {{ $t->truck->plate_number ?? '-' }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Persons:</span>

                                <div class="person-stack">

                                    {{-- DRIVER --}}
                                    <div class="person-avatar" data-name="{{ $t->driver->name ?? '' }}"
                                        data-initial="{{ strtoupper(substr($t->driver->name ?? '?', 0, 1)) }}">

                                        {{ strtoupper(substr($t->driver->name ?? '?', 0, 1)) }}

                                    </div>

                                    {{-- HELPERS --}}
                                    @foreach ($t->helpers as $h)
                                        <div class="person-avatar" data-name="{{ $h->name }}"
                                            data-initial="{{ strtoupper(substr($h->name, 0, 1)) }}">

                                            {{ strtoupper(substr($h->name, 0, 1)) }}

                                        </div>
                                    @endforeach

                                </div>
                            </div>


                            <hr class="my-3">

                        </div> {{-- END small --}}

                        {{-- ACTION BUTTONS --}}
                        <div class="trip-actions mt-auto">

                            <div class="trip-icons">

                                @if ($t->status == 'Draft')
                                    {{-- EDIT --}}
                                    <button class="btn btn-outline-dark btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editTripModal-{{ $t->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    {{-- DELETE --}}
                                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#confirmDelete-{{ $t->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    {{-- DISPATCH --}}
                                    <form method="POST" action="{{ route('owner.trips.assign', $t->id) }}"
                                        class="trip-dispatch">
                                        @csrf
                                        <button class="btn btn-warning btn-sm w-100">
                                            Assign Trip
                                        </button>
                                    </form>
                                @endif

                                @if ($t->status == 'Assigned')
                                    <div class="d-flex gap-2">

                                        {{-- READY TO DISPATCH --}}
                                        <button class="btn btn-primary btn-sm w-100" data-bs-toggle="modal"
                                            data-bs-target="#dispatchModal-{{ $t->id }}">
                                            Ready to Dispatch
                                        </button>

                                        {{-- DELETE --}}
                                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#confirmDelete-{{ $t->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </div>
                                @endif


                                @if ($t->status == 'Dispatched')
                                    <div class="d-flex gap-2">

                                        {{-- DELIVERED --}}
                                        <form method="POST" action="{{ route('owner.trips.deliver', $t->id) }}"
                                            class="trip-dispatch w-100">
                                            @csrf
                                            <button class="btn btn-success btn-sm w-100">
                                                Delivered
                                            </button>
                                        </form>

                                        {{-- DELETE --}}
                                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#confirmDelete-{{ $t->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </div>
                                @endif

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        @empty

            <div class="text-center py-5">
                <div class="text-muted mb-2"><i class="bi bi-truck fs-3"></i></div>
                <div class="fw-semibold">No trips found</div>
                <div class="text-muted small">Create your first dispatch to get started.</div>
            </div>
        @endforelse

    </div>

</div>
