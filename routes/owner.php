<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Owner\TripController;

Route::middleware(['auth'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('owner.dashboard');
        })->name('dashboard');

        // TRIPS
        Route::get('/trips', [TripController::class, 'index'])->name('trips.index');
        Route::get('/trips/create', [TripController::class, 'create'])->name('trips.create');
        Route::post('/trips', [TripController::class, 'store'])->name('trips.store');
        Route::get('/trips/{id}/edit', [TripController::class, 'edit'])->name('trips.edit');
        Route::put('/trips/{id}', [TripController::class, 'update'])->name('trips.update');
        Route::get('/trips/{id}', [TripController::class, 'show'])->name('trips.show');
        Route::delete('/trips/{id}', [TripController::class, 'destroy'])->name('trips.destroy');
    });
