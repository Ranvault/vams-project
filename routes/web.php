<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// Route Halaman Public
Route::get('/', [BookingController::class, 'index'])->name('home');
Route::get('/trip/{trip}/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/trip/{trip}/booking', [BookingController::class, 'store'])->name('booking.store');

// Route Cek Booking & Upload Pembayaran (Public)
Route::get('/cek-booking', [BookingController::class, 'cekBooking'])->name('booking.cek');
Route::post('/booking/{booking}/payment', [BookingController::class, 'uploadPayment'])->name('booking.payment');

// Redirect dashboard Breeze ke Kelola Trip
Route::get('/dashboard', function () {
    return redirect()->route('admin.trips.index');
})->middleware(['auth'])->name('dashboard');

// Route Khusus Admin (Wajib Login)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('trips', TripController::class)->except(['show']);
    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::patch('payments/{payment}/verifikasi', [AdminBookingController::class, 'verifikasi'])->name('payments.verifikasi');
    Route::delete('bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
});

require __DIR__.'/auth.php';