<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        return view('owner.trips.index');
    }

    public function create()
    {
        return view('owner.trips.create');
    }

    public function edit($id)
    {
        return view('owner.trips.edit');
    }

    public function show($id)
    {
        return view('owner.trips.show');
    }
}
