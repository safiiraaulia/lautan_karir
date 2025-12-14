<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LowonganController extends Controller
{
    public function index()
    {
        $lowongans = Lowongan::with(['posisi', 'dealer'])
                            ->where('status', 'Buka')
                            ->whereDate('tgl_tutup', '>=', now())
                            ->latest()
                            ->paginate(9);

        return view('public.lowongan.index', compact('lowongans'));
    }

    public function show(Lowongan $lowongan)
    {
        if ($lowongan->status !== 'Buka' || $lowongan->tgl_tutup < now()->startOfDay()) {
            return redirect()->route('lowongan.index')->with('error', 'Maaf, lowongan ini sudah ditutup.');
        }

        $lowongan->load(['posisi.kriteria', 'dealer']);

        return view('public.lowongan.show', compact('lowongan'));
    }

    /**
     * Function untuk AJAX Detail (Yang Gagal DImuat Tadi)
     */
    public function detail($id)
    {
        // PERBAIKAN: Gunakan where('id_lowongan', $id) agar pasti cocok dengan database
        $lowongan = Lowongan::with(['dealer', 'posisi.kriteria'])
                    ->where('id_lowongan', $id)
                    ->first();

        if (!$lowongan) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'id'        => $lowongan->id_lowongan,
            'posisi'    => $lowongan->posisi->nama_posisi,
            'dealer'    => $lowongan->dealer->nama_dealer,
            'kota'      => $lowongan->dealer->kota,
            'deskripsi' => $lowongan->deskripsi,
            'tgl_buka'  => Carbon::parse($lowongan->tgl_buka)->translatedFormat('d F Y'),
            'tgl_tutup' => Carbon::parse($lowongan->tgl_tutup)->translatedFormat('d F Y'),
            
            // Mapping Syarat
            'kriteria'  => $lowongan->posisi->kriteria->map(function($k) {
                $nama = $k->nama_kriteria;
                $syarat = $k->pivot->syarat ?? ''; 
                
                if (!empty($syarat)) {
                    return "<strong>{$nama}</strong>: {$syarat}";
                }
                return $nama;
            }),
        ]);
    }
}