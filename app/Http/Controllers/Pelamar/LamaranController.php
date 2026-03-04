<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\SkalaNilai;
use App\Models\JawabanAdministrasi; // Gunakan Model, jangan DB table saja
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
        $pelamar = Auth::guard('pelamar')->user();

        // 1. CEK KELENGKAPAN PROFIL
        $isProfileComplete = $pelamar->nama && $pelamar->nomor_whatsapp && $pelamar->path_cv;

        if (!$isProfileComplete) {
            return redirect()->route('pelamar.profile.edit')
                             ->with('error', 'Mohon lengkapi profil (Nama, WhatsApp, CV) sebelum melamar.');
        }

        // 2. CEK APAKAH SUDAH PERNAH MELAMAR
        if (Lamaran::where('lowongan_id', $lowongan->id_lowongan)->where('pelamar_id', $pelamar->id_pelamar)->exists()) {
            return redirect()->route('pelamar.dashboard')->with('error', 'Anda sudah melamar posisi ini.');
        }

        // 3. AMBIL DATA KRITERIA & OPSI
        $kriterias = $lowongan->posisi->kriteria->map(function ($k) use ($lowongan) {
            $k->opsi = SkalaNilai::where('kriteria_id', $k->id_kriteria)
                                ->where('posisi_id', $lowongan->posisi_id)
                                ->orderBy('nilai', 'desc')
                                ->get();
            return $k;
        });

        return view('pelamar.lamaran.create', compact('lowongan', 'pelamar', 'kriterias'));
    }

    /**
     * Memproses Penyimpanan Lamaran
     */
    public function store(Request $request, Lowongan $lowongan)
    {
        $pelamar = Auth::guard('pelamar')->user();

        // Validasi agar tidak ada jawaban yang kosong
        $request->validate([
            'jawaban' => 'required|array', 
        ], [
            'jawaban.required' => 'Wajib mengisi semua kriteria administrasi.'
        ]);

        try {
            DB::transaction(function () use ($request, $lowongan, $pelamar) {
                
                // 1. Simpan Data Utama Lamaran
                $lamaran = Lamaran::create([
                    'lowongan_id' => $lowongan->id_lowongan,
                    'pelamar_id'  => $pelamar->id_pelamar,
                    'tgl_melamar' => now(),
                    'status'      => 'Proses Seleksi', // Default status awal
                ]);

                // 2. Simpan Detail Jawaban Seleksi (MENGGUNAKAN MODEL)
                foreach ($request->jawaban as $kriteria_id => $skala_nilai_id) {
                    $skala = SkalaNilai::find($skala_nilai_id);

                    if ($skala) {
                        // Pakai Model JawabanAdministrasi agar sinkron dengan Primary Key id_jawaban
                        JawabanAdministrasi::create([
                            'lamaran_id'     => $lamaran->id_lamaran, 
                            'kriteria_id'    => $kriteria_id,
                            'skala_nilai_id' => $skala_nilai_id,
                            'nilai'          => $skala->nilai, 
                        ]);
                    }
                }
            });

            return redirect()->route('pelamar.dashboard')
                             ->with('success', 'Lamaran berhasil dikirim! Silakan pantau status di dashboard.');

        } catch (\Exception $e) {
            // Jika ada error (misal koneksi DB), batalkan semua proses
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function markRead()
    {
        $pelamarId = Auth::guard('pelamar')->id();
        
        // Update kolom is_read menjadi 1 (true) untuk status Lolos/Gagal
        \App\Models\Lamaran::where('pelamar_id', $pelamarId)
            ->whereIn('status', ['Lolos Seleksi', 'Gagal Seleksi'])
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }
}