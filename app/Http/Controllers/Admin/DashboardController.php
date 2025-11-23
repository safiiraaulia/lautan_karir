<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelamar; // Total Pelamar Terdaftar
use App\Models\Lowongan; // Lowongan Buka
use App\Models\Lamaran; // Total Lamaran & Status
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Metrik Dasar
        $totalPelamar = Pelamar::count();
        $lowonganBuka = Lowongan::where('status', 'Buka')->count();
        $totalLamaran = Lamaran::count();

        // 2. Ambil Status Lamaran (untuk Grafik/Persentase)
        $statusCounts = Lamaran::select('status', DB::raw('count(*) as count'))
                               ->groupBy('status')
                               ->get()
                               ->pluck('count', 'status');

        $prosesAdminCount = $statusCounts['Proses Administrasi'] ?? 0;
        $lolosAdminCount = $statusCounts['Lolos Administrasi'] ?? 0;
        $gagalAdminCount = $statusCounts['Gagal Administrasi'] ?? 0;
        
        // 3. Ambil 5 Lamaran Terbaru (untuk Aktivitas Terbaru)
        $lamaranTerbaru = Lamaran::with('lowongan.posisi', 'pelamar')
                                ->latest()
                                ->take(5)
                                ->get();
                                
        // 4. Hitung Persentase Lolos (Opsional)
        $totalSeleksi = $lolosAdminCount + $gagalAdminCount;
        $persentaseLolos = $totalSeleksi > 0 ? round(($lolosAdminCount / $totalSeleksi) * 100) : 0;


        return view('admin.dashboard', compact(
            'totalPelamar',
            'lowonganBuka',
            'totalLamaran',
            'prosesAdminCount',
            'lolosAdminCount',
            'gagalAdminCount',
            'persentaseLolos',
            'lamaranTerbaru'
        ));
    }
}