<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\SkalaNilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LamaranController extends Controller
{
    /**
     * Menampilkan Formulir Lamaran
     */
    public function create(Lowongan $lowongan)
    {
        // 1. Cek apakah pelamar sudah pernah melamar di lowongan ini
        $pelamar = Auth::guard('pelamar')->user();
        
        $sudahMelamar = Lamaran::where('lowongan_id', $lowongan->id_lowongan)
                            ->where('pelamar_id', $pelamar->id_pelamar)
                            ->exists();

        if ($sudahMelamar) {
            return redirect()->route('pelamar.dashboard')
                             ->with('error', 'Anda sudah melamar posisi ini sebelumnya.');
        }

        // 2. Ambil data Kriteria & Opsi Jawaban (Skala Nilai)
        $lowongan->load('posisi.kriteria');

        $kriterias = $lowongan->posisi->kriteria->map(function ($kriteria) use ($lowongan) {
            // Ambil opsi jawaban khusus untuk posisi ini
            $kriteria->opsi = SkalaNilai::where('kriteria_id', $kriteria->id_kriteria)
                                ->where('posisi_id', $lowongan->posisi_id)
                                ->orderBy('nilai', 'desc')
                                ->get();
            return $kriteria;
        });

        return view('pelamar.lamaran.create', compact('lowongan', 'pelamar', 'kriterias'));
    }

    /**
     * Memproses Penyimpanan Lamaran
     */
    public function store(Request $request, Lowongan $lowongan)
    {
        $pelamar = Auth::guard('pelamar')->user();

        $request->validate([
            'jawaban' => 'required|array', 
        ]);

        DB::transaction(function () use ($request, $lowongan, $pelamar) {
            
            // 2. Simpan Data Utama Lamaran
            $lamaran = Lamaran::create([
                'lowongan_id' => $lowongan->id_lowongan,
                'pelamar_id'  => $pelamar->id_pelamar,
                'tgl_melamar' => now(),
                'status'      => 'Sedang Diproses',
                'is_read'     => false,
            ]);

            // 3. Simpan Detail Jawaban Seleksi
            foreach ($request->jawaban as $kriteria_id => $skala_nilai_id) {
                
                $skala = SkalaNilai::find($skala_nilai_id);

                if ($skala) {
                    DB::table('jawaban_administrasi')->insert([
                        // PERBAIKAN DISINI: Gunakan 'id_lamaran', bukan 'id'
                        'lamaran_id'     => $lamaran->id_lamaran, 
                        'kriteria_id'    => $kriteria_id,
                        'skala_nilai_id' => $skala_nilai_id,
                        'nilai'          => $skala->nilai, 
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                }
            }
        });

        return redirect()->route('pelamar.dashboard')
                         ->with('success', 'Lamaran berhasil dikirim! Pantau status seleksi di dashboard Anda.');
    }

    public function markRead(Request $request)
    {
        $pelamar = Auth::guard('pelamar')->user();

        // Update semua lamaran milik pelamar ini yang statusnya sudah final dan belum dibaca
        \App\Models\Lamaran::where('pelamar_id', $pelamar->id_pelamar)
               ->where('is_read', false)
               ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}