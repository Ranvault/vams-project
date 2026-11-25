<?php

use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// Route Halaman Public
Route::get('/', [BookingController::class, 'index'])->name('home');
Route::get('/trip/{trip}/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/trip/{trip}/booking', [BookingController::class, 'store'])->name('booking.store');

// Route sementara untuk Cek Booking (akan dilengkapi di Tahap 4)
Route::get('/cek-booking', function () {
    return "Halaman Cek Booking & Upload Pembayaran (Akan dibuat di Tahap 4) - Kode: " . request('kode_booking');
})->name('booking.cek');

// Redirect dashboard Breeze ke Kelola Trip
Route::get('/dashboard', function () {
    return redirect()->route('admin.trips.index');
})->middleware(['auth'])->name('dashboard');

// Route Khusus Admin (Wajib Login)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('trips', TripController::class)->except(['show']);
});

require __DIR__.'/auth.php';