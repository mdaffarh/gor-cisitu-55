<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\FasilitasTambahanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;

// landing page
Route::get('/', function () {
    return view('index');
});

// login form
Route::get('/admin', function () {
    return view('login');
})->name('login')->middleware('guest');

// login dan logout
Route::post('/login', [LoginController::class, 'authenticate'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('admin');

// fasilitas
Route::resource('/dashboard/fasilitas', FasilitasController::class)->middleware('admin');

// fasilitas tambahan
Route::resource('/dashboard/fasilitas_tambahan', FasilitasTambahanController::class)->middleware('admin');

// voucher
Route::resource('/dashboard/voucher', VoucherController::class)->middleware('admin');

// membership
Route::resource('/dashboard/membership', MembershipController::class)->middleware('admin');

// booking
Route::resource('/dashboard/booking', BookingController::class)->middleware('admin');
Route::get('/dashboard/booking/cancel/{id}', [BookingController::class, 'cancel'])->middleware('admin');

Route::get('/dashboard/jadwal/cek-jadwal', [BookingController::class, 'showCekJadwal'])->middleware('admin');
Route::post('/dashboard/jadwal/cek-jadwal', [BookingController::class, 'cekJadwal'])->middleware('admin');
