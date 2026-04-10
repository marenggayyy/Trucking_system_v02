@extends('layouts.owner')

@section('page-class', 'page-trips')

@section('content')

<div class="p-4">

    @include('owner.trips.partials.header')

    @include('owner.trips.partials.cards')

    @include('owner.trips.partials.modals')

</div>

@endsection