<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PendaftaranController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/pendaftaran', [PendaftaranController::class, 'create'])
    ->middleware('auth:pasien')
    ->name('pendaftaran');

Route::post('/pendaftaran', [PendaftaranController::class, 'store'])
    ->middleware('auth:pasien')
    ->name('pendaftaran.store');


Route::get('/login', [PasienController::class, 'showLoginForm'])->name('login');
Route::post('/login', [PasienController::class, 'login'])->name('login.submit');
Route::post('/logout', [PasienController::class, 'logout'])->name('logout');


Route::get('/registrasi', [PasienController::class, 'showRegistrationForm'])->name('pasien.register');
Route::post('/registrasi', [PasienController::class, 'register'])->name('pasien.register.store');
