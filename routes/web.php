<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\PelamarLoginController;
use App\Http\Controllers\Auth\PelamarRegisterController;
use App\Http\Controllers\Admin\DealerController;
use App\Http\Controllers\Admin\PosisiController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| ADMIN / HR ROUTES
|--------------------------------------------------------------------------
*/

// ✅ Login Admin (guard: admin)
Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'login']);
});

// ✅ Logout Admin
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// ✅ Dashboard & Menu Admin (auth:admin)
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | SUPER_ADMIN ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:SUPER_ADMIN'])->group(function () {
        Route::get('/users', function () { return "Kelola User"; })->name('admin.users.index');
        Route::get('/settings', function () { return "Setting Sistem"; })->name('admin.settings');
    });

    /*
    |--------------------------------------------------------------------------
    | SUPER_ADMIN & HR_PUSAT
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:SUPER_ADMIN,HR_PUSAT'])->group(function () {

        // ✅ MASTER DEALER
        Route::resource('dealer', DealerController::class, [
            'as' => 'admin'
        ]);

        // ✅ MASTER POSISI
        Route::resource('posisi', PosisiController::class, [
            'as' => 'admin'
        ]);

        // ✅ MENU LAIN (masih placeholder)
        Route::get('/kriteria', fn() => "Halaman Master Kriteria")->name('admin.kriteria.index');
        Route::get('/paket-tes', fn() => "Halaman Master Paket Tes")->name('admin.paket_tes.index');
        Route::get('/lowongan', fn() => "Halaman Kelola Lowongan")->name('admin.lowongan.index');
        Route::get('/lamaran', fn() => "Halaman Review Lamaran")->name('admin.lamaran.index');
        Route::get('/hasil-tes', fn() => "Halaman Hasil Tes")->name('admin.hasil_tes.index');
    });
});


/*
|--------------------------------------------------------------------------
| PELAMAR ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/pelamar/register', [PelamarRegisterController::class, 'showRegistrationForm'])->name('pelamar.register');
Route::post('/pelamar/register', [PelamarRegisterController::class, 'register']);

Route::get('/pelamar/login', [PelamarLoginController::class, 'showLoginForm'])->name('pelamar.login');
Route::post('/pelamar/login', [PelamarLoginController::class, 'login']);
Route::post('/pelamar/logout', [PelamarLoginController::class, 'logout'])->name('pelamar.logout');

Route::middleware(['auth.pelamar'])->prefix('pelamar')->group(function () {
    Route::get('/dashboard', function () {
        return view('pelamar.dashboard');
    })->name('pelamar.dashboard');
});
