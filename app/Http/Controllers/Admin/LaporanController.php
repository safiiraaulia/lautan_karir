<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\Posisi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Halaman Utama Laporan (Filter & Preview)
     */
    public function index(Request $request)
    {
        // Ambil data untuk filter dropdown
        $lowongans = Lowongan::with('posisi', 'dealer')->latest()->get();
        
        // Query Dasar Lamaran
        $query = Lamaran::with(['pelamar', 'lowongan.posisi', 'lowongan.dealer'])
            ->whereHas('lowongan');

        // --- LOGIKA FILTER ---
        
        // Filter by Lowongan
        if ($request->has('lowongan_id') && $request->lowongan_id != '') {
            $query->where('lowongan_id', $request->lowongan_id);
        }

        // Filter by Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by Tanggal (Range)
        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('tgl_melamar', [$request->tgl_awal, $request->tgl_akhir]);
        }

        // Ambil data hasil filter
        $lamarans = $query->latest()->get();

        return view('admin.laporan.index', compact('lamarans', 'lowongans'));
    }

    /**
     * Cetak Laporan ke PDF (Tampilan Cetak)
     */
    public function cetak(Request $request)
    {
        $query = Lamaran::with(['pelamar', 'lowongan.posisi', 'lowongan.dealer']);

        // 1. Filter Lowongan
        $selectedLowongan = null; // Variabel untuk menyimpan nama lowongan
        if ($request->has('lowongan_id') && $request->lowongan_id != '') {
            $query->where('lowongan_id', $request->lowongan_id);
            
            // AMBIL DATA LOWONGAN UNTUK JUDUL LAPORAN
            $selectedLowongan = Lowongan::with(['posisi', 'dealer'])->find($request->lowongan_id);
        }

        // 2. Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // 3. Filter Tanggal
        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('tgl_melamar', [$request->tgl_awal, $request->tgl_akhir]);
        }

        $lamarans = $query->latest()->get();
        
        // Kirim variabel $selectedLowongan ke view
        return view('admin.laporan.cetak', compact('lamarans', 'selectedLowongan'));
    }
}