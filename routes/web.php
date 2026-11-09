<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

// Katalog & Daftar Film
Route::get('/', [MovieController::class, 'index'])->name('movies.index');
Route::get('/film/{slug}', [MovieController::class, 'show'])->name('movies.show');

// Pemesanan Tiket, Pilih Kursi & Makanan
Route::get('/pesan/{showtime}', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/pesan', [BookingController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('bookings.store');

// Konfirmasi & Download Barcode Tiket
Route::get('/pesanan/{booking_code}', [BookingController::class, 'show'])->name('bookings.show');

// Cek & Cari Tiket
Route::get('/cek-tiket', [BookingController::class, 'lookup'])
    ->middleware('throttle:25,1')
    ->name('bookings.lookup');
