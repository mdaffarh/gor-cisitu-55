<?php

use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

// landing page
Route::get('/', function () {
    return view('index');
});

// login form
Route::get('/admin', function () {
    return view('login');
})->name('login');

// login dan logout
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

// dashboard index
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('admin');

// fasilitas
Route::resource('/dashboard/fasilitas', FasilitasController::class);
