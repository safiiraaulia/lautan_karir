<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\PelamarLoginController;
use App\Http\Controllers\Auth\PelamarRegisterController;
use App\Http\Controllers\Admin\DealerController;
use App\Http\Controllers\Admin\PosisiController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\SkalaNilaiController;
use App\Http\Controllers\Admin\LowonganController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PelamarController;
use App\Http\Controllers\Admin\SeleksiController;
use App\Http\Controllers\Front\LowonganController as PublicLowonganController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicLowonganController::class, 'index'])->name('home');
Route::get('/lowongan', [PublicLowonganController::class, 'index'])->name('lowongan.index');
Route::get('/lowongan/{lowongan}', [PublicLowonganController::class, 'show'])->name('lowongan.show');

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
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])
    ->name('admin.logout');

// ✅ Dashboard & Menu Admin (auth:admin)
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    

    /*
    |--------------------------------------------------------------------------
    | SUPER_ADMIN ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:SUPER_ADMIN'])->group(function () {
        Route::get('/settings', function () { return "Setting Sistem"; })->name('admin.settings');
    });

    // GANTI DENGAN INI
    Route::resource('users', UserController::class, [
        'as' => 'admin'
    ]);

    /*
    |--------------------------------------------------------------------------
    | SUPER_ADMIN & HRD
    |--------------------------------------------------------------------------
    */
        Route::middleware(['role:SUPER_ADMIN,HRD'])->group(function () {

        // MASTER DEALER
        Route::resource('dealer', DealerController::class, [
            'as' => 'admin'
        ]);

        // MASTER POSISI
        Route::resource('posisi', PosisiController::class, [
            'as' => 'admin'
        ]);

        // Route untuk menampilkan halaman setup
        Route::get('posisi/{posisi}/setup-saw', [PosisiController::class, 'setupSaw'])
            ->name('admin.posisi.setupSaw');
        // Route untuk menyimpan data setup
        Route::post('posisi/{posisi}/setup-saw', [PosisiController::class, 'storeSaw'])
            ->name('admin.posisi.storeSaw');

        // MASTER KRITERIA
        Route::resource('kriteria', KriteriaController::class, [
            'as' => 'admin'
        ])->parameters([
            'kriteria' => 'kriteria'
        ]);

        // MASTER SKALA NILAI
        Route::resource('skala-nilai', SkalaNilaiController::class, [
            'as' => 'admin'
        ]);

        // KELOLA LOWONGAN
        Route::resource('lowongan', LowonganController::class, [
            'as' => 'admin'
        ]);

        Route::prefix('seleksi')->name('admin.seleksi.')->group(function () {
            Route::get('/', [SeleksiController::class, 'index'])->name('index'); 
            Route::get('/{lowongan}', [SeleksiController::class, 'show'])->name('show');
            Route::post('/{lamaran}/update-status', [SeleksiController::class, 'updateStatus'])->name('updateStatus');
        });

       
        Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
        Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('admin.laporan.cetak');

        Route::get('pelamar', [PelamarController::class, 'index'])->name('admin.pelamar.index');
        Route::get('pelamar/{pelamar}', [PelamarController::class, 'show'])->name('admin.pelamar.show');
        Route::post('pelamar/{pelamar}/toggle-status', [PelamarController::class, 'toggleStatus'])->name('admin.pelamar.toggleStatus');

        // MENU LAIN (masih placeholder)
       
        Route::get('/paket-tes', fn() => "Halaman Master Paket Tes")->name('admin.paket_tes.index');
        Route::get('/lamaran', fn() => "Halaman Review Lamaran")->name('admin.lamaran.index');
        Route::get('/hasil-tes', fn() => "Halaman Hasil Tes")->name('admin.hasil_tes.index');
    });
});


/*
|--------------------------------------------------------------------------
| PELAMAR ROUTES
|--------------------------------------------------------------------------
*/

// Route Tamu (Guest) - Register & Login
Route::group(['middleware' => 'guest:pelamar'], function () {
    Route::get('/pelamar/register', [PelamarRegisterController::class, 'showRegistrationForm'])->name('pelamar.register');
    Route::post('/pelamar/register', [PelamarRegisterController::class, 'register']);

    Route::get('/pelamar/login', [PelamarLoginController::class, 'showLoginForm'])->name('pelamar.login');
    Route::post('/pelamar/login', [PelamarLoginController::class, 'login']);
});

// Route Logout (Butuh Auth)
Route::post('/pelamar/logout', [PelamarLoginController::class, 'logout'])->name('pelamar.logout')->middleware('auth:pelamar');

// Route Halaman Utama Pelamar (Butuh Auth)
Route::middleware(['auth:pelamar'])->prefix('pelamar')->name('pelamar.')->group(function () {
    
    // --- DASHBOARD ---
    Route::get('/dashboard', function () {
        $pelamar = Auth::guard('pelamar')->user();

        // 1. Cek Kelengkapan Profil
        $isProfileComplete = !empty($pelamar->nama) && 
                             !empty($pelamar->nomor_whatsapp) && 
                             !empty($pelamar->path_cv);

        // 2. Ambil Riwayat Lamaran
        $lamarans = \App\Models\Lamaran::with(['lowongan.posisi', 'lowongan.dealer'])
                        ->where('pelamar_id', $pelamar->id_pelamar)
                        ->latest('tgl_melamar')
                        ->get();

        return view('pelamar.dashboard', compact('pelamar', 'isProfileComplete', 'lamarans'));
    })->name('dashboard');

    // --- PROFILE ---
    Route::get('/profile', [App\Http\Controllers\Pelamar\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\Pelamar\ProfileController::class, 'update'])->name('profile.update');
    
    // --- PROSES LAMARAN ---
    Route::get('/lamar/{lowongan}', [App\Http\Controllers\Pelamar\LamaranController::class, 'create'])->name('lamaran.create');
    Route::post('/lamar/{lowongan}', [App\Http\Controllers\Pelamar\LamaranController::class, 'store'])->name('lamaran.store');
});