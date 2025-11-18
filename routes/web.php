<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DashboardController;

// Ganti rute dashboard yang lama dengan yang ini
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk MENAMPILKAN formulir
    Route::get('/predict', [PredictionController::class, 'showForm'])->name('predict.form');

    // Rute untuk MENERIMA data formulir (akan kita gunakan di Tahap 2.C)
    Route::post('/predict', [PredictionController::class, 'submitForm'])->name('predict.submit');

    Route::resource('/customers', CustomerController::class);

    Route::resource('/vehicles', VehicleController::class);

    Route::get('/history', [PredictionController::class, 'showHistory'])->name('predict.history');
});

require __DIR__ . '/auth.php';
