<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
use App\Http\Controllers\Pelamar\LamaranController;
use App\Http\Controllers\Pelamar\ProfileController;
use App\Http\Controllers\TesController;
use App\Http\Controllers\Admin\SoalController;
use App\Http\Controllers\Admin\HasilTesController;
use App\Http\Controllers\Pelamar\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicLowonganController::class, 'index'])->name('home');
Route::get('/lowongan', [PublicLowonganController::class, 'index'])->name('lowongan.index');
Route::get('/lowongan/{lowongan}', [PublicLowonganController::class, 'show'])->name('lowongan.show');
Route::get('/lowongan/{id}/detail', [PublicLowonganController::class, 'detail'])->name('lowongan.detail.ajax');

// --- Rute Login & Register Pelamar ---
Route::middleware('guest:pelamar')->group(function () {
    Route::get('/login', [PelamarLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PelamarLoginController::class, 'login']);
    Route::get('/register', [PelamarRegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [PelamarRegisterController::class, 'register']);
    Route::get('/forgot-password', [App\Http\Controllers\Pelamar\ForgotPasswordController::class, 'showLinkRequestForm'])->name('pelamar.password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Pelamar\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('pelamar.password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Pelamar\ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Pelamar\ForgotPasswordController::class, 'resetPassword'])->name('pelamar.password.update');
});

/*
|--------------------------------------------------------------------------
| ADMIN / HR ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'login']);
});

Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth:admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::middleware(['role:SUPER_ADMIN'])->group(function () {
        Route::get('/settings', function () { return "Setting Sistem"; })->name('admin.settings');
    });

    Route::resource('users', UserController::class, ['as' => 'admin']);

    Route::middleware(['role:SUPER_ADMIN,HRD'])->group(function () {
        Route::get('dealer/{id}/restore', [DealerController::class, 'restore'])->name('admin.dealer.restore');
        Route::delete('dealer/{id}/force-delete', [DealerController::class, 'forceDelete'])->name('admin.dealer.force-delete');
        Route::resource('dealer', DealerController::class, ['as' => 'admin']);

        Route::get('posisi/{id}/restore', [PosisiController::class, 'restore'])->name('admin.posisi.restore');
        Route::delete('posisi/{id}/force-delete', [PosisiController::class, 'forceDelete'])->name('admin.posisi.force-delete');
        Route::resource('posisi', PosisiController::class, ['as' => 'admin']);
        Route::get('posisi/{posisi}/setup-saw', [PosisiController::class, 'setupSaw'])->name('admin.posisi.setupSaw');
        Route::post('posisi/{posisi}/setup-saw', [PosisiController::class, 'storeSaw'])->name('admin.posisi.storeSaw');

        Route::get('kriteria/{id}/restore', [KriteriaController::class, 'restore'])->name('admin.kriteria.restore');
        Route::delete('kriteria/{id}/force-delete', [KriteriaController::class, 'forceDelete'])->name('admin.kriteria.force-delete');
        Route::resource('kriteria', KriteriaController::class, ['as' => 'admin'])->parameters(['kriteria' => 'kriteria']);
        Route::resource('kriteria', KriteriaController::class, ['as' => 'admin'])->parameters(['kriteria' => 'kriteria']);
        Route::resource('skala-nilai', SkalaNilaiController::class, ['as' => 'admin']);

        Route::get('lowongan/{id}/restore', [LowonganController::class, 'restore'])->name('admin.lowongan.restore');
        Route::delete('lowongan/{id}/force-delete', [LowonganController::class, 'forceDelete'])->name('admin.lowongan.force-delete');
        Route::resource('lowongan', LowonganController::class, ['as' => 'admin']);

        Route::prefix('seleksi')->name('admin.seleksi.')->group(function () {
            Route::get('/', [SeleksiController::class, 'index'])->name('index'); 
            Route::get('/{lowongan}', [SeleksiController::class, 'show'])->name('show');
            Route::post('/{lamaran}/update-status', [SeleksiController::class, 'updateStatus'])->name('updateStatus');
            Route::put('/{lamaran}/kesimpulan', [SeleksiController::class, 'updateKesimpulan'])->name('updateKesimpulan');
            Route::post('/{lowongan}/simpan-ranking', [SeleksiController::class, 'simpanRanking'])->name('simpanRanking');
        });
       
        Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
        Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('admin.laporan.cetak');
        Route::get('pelamar', [PelamarController::class, 'index'])->name('admin.pelamar.index');
        Route::get('pelamar/{pelamar}', [PelamarController::class, 'show'])->name('admin.pelamar.show');
        Route::post('pelamar/{pelamar}/toggle-status', [PelamarController::class, 'toggleStatus'])->name('admin.pelamar.toggleStatus');
        Route::resource('bank-soal', SoalController::class, [
            'as' => 'admin'
        ]);
        
        Route::get('/lamaran', fn() => "Halaman Review Lamaran")->name('admin.lamaran.index');
        
        Route::get('/hasil-tes', [HasilTesController::class, 'index'])->name('admin.hasil_tes.index');

    });
});

/*
|--------------------------------------------------------------------------
| PELAMAR ROUTES (BUTUH AUTHENTIKASI)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:pelamar', 'checkActive'])
    ->prefix('pelamar')
    ->name('pelamar.')
    ->group(function () {

        // --- DASHBOARD ---
        Route::get('/dashboard', function () {
            $pelamar = Auth::guard('pelamar')->user();
            $isProfileComplete = !empty($pelamar->nama) && !empty($pelamar->nomor_whatsapp) && !empty($pelamar->path_cv);
            $lamarans = \App\Models\Lamaran::with(['lowongan.posisi', 'lowongan.dealer'])
                ->where('pelamar_id', $pelamar->id_pelamar)
                ->whereHas('lowongan', fn($q) => $q->whereHas('posisi'))
                ->latest('tgl_melamar')
                ->get();
            $unread = \App\Models\Lamaran::where('pelamar_id', $pelamar->id_pelamar)->where('is_read', 0)->count();

            return view('pelamar.dashboard', compact('pelamar', 'isProfileComplete', 'lamarans', 'unread'));
        })->name('dashboard');

        // --- LOGOUT ---
        Route::post('/logout', [App\Http\Controllers\Auth\PelamarLoginController::class, 'logout'])->name('logout');

        // --- PROFILE ---
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // --- PROSES LAMARAN ---
        Route::get('/lamar/{lowongan}', [LamaranController::class, 'create'])->name('lamaran.create');
        Route::post('/lamar/{lowongan}', [LamaranController::class, 'store'])->name('lamaran.store');
        Route::post('/dashboard/mark-read', [LamaranController::class, 'markRead'])->name('markRead'); 

        // --- TES PSIKOLOGI (DISC & PAPIKOSTIK) ---
        Route::get('/tes', [TesController::class, 'index'])->name('tes.index');
        Route::get('/tes/{id}', [TesController::class, 'show'])->name('tes.show');

        Route::post('/tes/simpan', [TesController::class, 'store'])->name('tes.store');
    });