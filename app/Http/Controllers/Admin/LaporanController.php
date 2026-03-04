<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\Posisi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $lowongans = Lowongan::with('posisi', 'dealer')->latest()->get();
        
        $query = Lamaran::with(['pelamar', 'lowongan.posisi', 'lowongan.dealer'])
            ->whereHas('lowongan');

        // --- LOGIKA FILTER ---
        if ($request->has('lowongan_id') && $request->lowongan_id != '') {
            $query->where('lowongan_id', $request->lowongan_id);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('tgl_melamar', [$request->tgl_awal, $request->tgl_akhir]);
        }

        $lamarans = $query->latest()->get();

        return view('admin.laporan.index', compact('lamarans', 'lowongans'));
    }

    public function cetak(Request $request)
    {
        $query = Lamaran::with(['pelamar', 'lowongan.posisi', 'lowongan.dealer']);

        $selectedLowongan = null; 
        if ($request->has('lowongan_id') && $request->lowongan_id != '') {
            $query->where('lowongan_id', $request->lowongan_id);
            
            $selectedLowongan = Lowongan::with(['posisi', 'dealer'])->find($request->lowongan_id);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('tgl_melamar', [$request->tgl_awal, $request->tgl_akhir]);
        }

        $lamarans = $query->latest()->get();
        
        return view('admin.laporan.cetak', compact('lamarans', 'selectedLowongan'));
    }
}