@extends('layouts.owner')

@section('title', 'Trips / Dispatch')

@section('page-class', 'page-trips')

@section('content')
    <div class="container-fluid py-3 px-1 px-lg-4">

        @include('owner.trips.partials.hero')

        @include('owner.trips.partials.available-resources')

        <div class="card ui-card border-0 mt-3">

            @include('owner.trips.partials.trips-header')

            @include('owner.trips.partials.trip-grid')

        </div>

        @include('owner.trips.partials.modals.new-trip')

    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/owner/trips/trips.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/owner/trips.js') }}"></script>
@endpush
