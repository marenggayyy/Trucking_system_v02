<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('owner')->group(function () {
        Route::get('/dashboard', function () {
            return view('owner.dashboard');
        })->name('owner.dashboard');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });

    Route::prefix('secretary')->group(function () {
        Route::get('/dashboard', function () {
            return view('secretary.dashboard');
        })->name('secretary.dashboard');
    });

    Route::prefix('it')->group(function () {
        Route::get('/dashboard', function () {
            return view('it.dashboard');
        })->name('it.dashboard');
    });

});

require __DIR__.'/auth.php';
