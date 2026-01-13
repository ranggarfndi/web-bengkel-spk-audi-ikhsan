<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleController;

// Halaman Utama langsung ke Dashboard (Wajib Login)
Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Group Route yang butuh Login
Route::middleware('auth')->group(function () {
    
    // 1. Modul Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Modul Prediksi / Diagnosa (INTI SISTEM)
    // Menampilkan Form
    Route::get('/predict', [PredictionController::class, 'showForm'])->name('predict.form');
    // Memproses Data (Kirim ke Python & Simpan DB)
    Route::post('/predict', [PredictionController::class, 'submitForm'])->name('predict.submit');
    // Menampilkan Riwayat
    Route::get('/history', [PredictionController::class, 'showHistory'])->name('predict.history');

    // 3. Modul Manajemen Data (CRUD)
    Route::resource('/customers', CustomerController::class);
    Route::resource('/vehicles', VehicleController::class);

});

require __DIR__ . '/auth.php';