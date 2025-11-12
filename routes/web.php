<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\PelamarLoginController;
use App\Http\Controllers\Auth\PelamarRegisterController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Tidak perlu login)
|--------------------------------------------------------------------------
*/

// Halaman Utama (Portal Lowongan)
Route::get('/', function () {
    return view('welcome'); // Nanti ganti ke 'portal.lowongan'
});

/*
|--------------------------------------------------------------------------
| ADMIN / HR PUSAT ROUTES
|--------------------------------------------------------------------------
*/

// Login Admin
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Dashboard Admin (Protected)
Route::middleware(['auth:web'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); // Nanti buat view ini
    })->name('admin.dashboard');
    
    // Nanti tambahkan route CRUD Master Data di sini
});

/*
|--------------------------------------------------------------------------
| PELAMAR ROUTES
|--------------------------------------------------------------------------
*/

// Register Pelamar
Route::get('/pelamar/register', [PelamarRegisterController::class, 'showRegistrationForm'])->name('pelamar.register');
Route::post('/pelamar/register', [PelamarRegisterController::class, 'register']);

// Login Pelamar
Route::get('/pelamar/login', [PelamarLoginController::class, 'showLoginForm'])->name('pelamar.login');
Route::post('/pelamar/login', [PelamarLoginController::class, 'login']);
Route::post('/pelamar/logout', [PelamarLoginController::class, 'logout'])->name('pelamar.logout');

// Dashboard Pelamar (Protected)
Route::middleware(['auth.pelamar'])->prefix('pelamar')->group(function () {
    Route::get('/dashboard', function () {
        return view('pelamar.dashboard'); // Nanti buat view ini
    })->name('pelamar.dashboard');
    
    // Nanti tambahkan route Lamaran & Tes di sini
});