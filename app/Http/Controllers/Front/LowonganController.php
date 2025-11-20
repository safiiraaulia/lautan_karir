<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    /**
     * Menampilkan daftar lowongan yang sedang dibuka.
     */
    public function index()
    {
        // Ambil lowongan yang statusnya 'Buka' dan tanggal tutup belum lewat
        $lowongans = Lowongan::with(['posisi', 'dealer'])
                            ->where('status', 'Buka')
                            ->whereDate('tgl_tutup', '>=', now())
                            ->latest()
                            ->paginate(9); // Tampilkan 9 lowongan per halaman

        return view('public.lowongan.index', compact('lowongans'));
    }

    /**
     * Menampilkan detail satu lowongan.
     */
    public function show(Lowongan $lowongan)
    {
        // Cek validasi: Status harus Buka dan belum kedaluwarsa
        if ($lowongan->status !== 'Buka' || $lowongan->tgl_tutup < now()->startOfDay()) {
             // Redirect jika tidak valid
            return redirect()->route('lowongan.index')->with('error', 'Maaf, lowongan ini sudah ditutup atau tidak tersedia.');
        }

        // Load relasi agar bisa ditampilkan
        $lowongan->load(['posisi', 'dealer', 'posisi.kriteria']);

        return view('public.lowongan.show', compact('lowongan'));
    }
}