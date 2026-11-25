<?php

use App\Http\Controllers\Admin\TripController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.trips.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.trips.index');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('trips', TripController::class)->except(['show']);
});

require __DIR__.'/auth.php';