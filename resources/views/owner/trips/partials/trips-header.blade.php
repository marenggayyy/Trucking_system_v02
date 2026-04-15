@php
    $trips = $trips ?? collect();
@endphp

<div class="card-header bg-transparent border-0 pb-0">

    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
        <div>
            <h6 class="mb-0 fw-semibold">Current Trips</h6>

            <div class="text-muted small mt-1">
                @if ($trips->count())
                    Showing <strong>1–{{ $trips->count() }}</strong> /
                    <strong>{{ $trips->count() }}</strong>
                @else
                    Showing <strong>0</strong> / <strong>0</strong>
                @endif
            </div>
        </div>

        <a href="#" class="btn btn-outline-secondary btn-sm ui-pill-btn">
            <i class="bi bi-clock-history me-1"></i> Trips History
        </a>
    </div>

    <div class="mt-3 d-flex flex-column flex-lg-row gap-2 align-items-stretch align-items-lg-center justify-content-between">

        <form method="GET" action="#" class="d-flex flex-column flex-sm-row gap-2 flex-grow-1">

            <div class="ui-search" style="max-width:520px; width:100%;">
                <i class="bi bi-search ui-search-icon"></i>
                <input type="text"
                       class="form-control ui-search-input"
                       placeholder="Search trip ticket, truck, driver...">
            </div>

            <div class="d-flex align-items-center gap-2">
                <label class="small text-muted m-0">Show</label>

                <select class="form-select form-select-sm" style="width:auto;">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>

                <span class="small text-muted">entries</span>
            </div>
        </form>

        <div class="d-flex gap-2">
            <button class="btn btn-warning btn-sm ui-pill-btn">
                <i class="bi bi-plus-lg me-1"></i> New Trip
            </button>

            <button class="btn btn-outline-danger btn-sm ui-pill-btn" disabled>
                <i class="bi bi-trash3 me-1"></i> Delete All
            </button>
        </div>
    </div>
</div>