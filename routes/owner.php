<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Owner\TripController;
use App\Http\Controllers\Owner\TruckController;
use App\Http\Controllers\Owner\EmployeeController;
use App\Http\Controllers\Owner\DestinationController;

Route::middleware(['auth'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('owner.dashboard');
        })->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | TRIPS
        |--------------------------------------------------------------------------
        */
        Route::prefix('trips')
            ->name('trips.')
            ->controller(TripController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/create', 'create')->name('create');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::put('/{id}', 'update')->name('update');
                Route::get('/{id}', 'show')->name('show');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

        /*
        |--------------------------------------------------------------------------
        | TRUCKS
        |--------------------------------------------------------------------------
        */
        Route::prefix('trucks')
            ->name('trucks.')
            ->controller(TruckController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::put('/{truck}', 'update')->name('update');
                Route::delete('/{truck}', 'destroy')->name('destroy');

                Route::post('/destroy-all', 'destroyAll')->name('destroyAll');
                Route::get('/sidebar/{truck}', 'sidebar')->name('sidebar');
            });

        /*
        |--------------------------------------------------------------------------
        | EMPLOYEES
        |--------------------------------------------------------------------------
        */
        Route::prefix('employees')
            ->name('employees.')
            ->controller(EmployeeController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::get('/create', 'create')->name('create');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::put('/{id}', 'update')->name('update');
                Route::get('/{id}', 'show')->name('show');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });

        /*
        |--------------------------------------------------------------------------
        | DESTINATIONS
        |--------------------------------------------------------------------------
        */
        Route::prefix('destinations')
            ->name('destinations.')
            ->controller(DestinationController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');

                Route::put('/{destination}', 'update')->name('update');
                Route::delete('/{destination}/{truck_type}', 'destroy')->name('destroy');
            });
    });
