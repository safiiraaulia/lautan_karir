<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\Kriteria;
use App\Models\SkalaNilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Pastikan ini ada jika belum

class SeleksiController extends Controller
{
    /**
     * Menampilkan daftar Lowongan yang masih Buka untuk dipilih.
     */
    public function index()
    {
        // Ambil lowongan yang masih buka dan belum tutup
        $lowongans = Lowongan::with('posisi', 'dealer')
                             ->where('status', 'Buka')
                             ->where('tgl_tutup', '>=', now())
                             ->latest()
                             ->get();

        return view('admin.seleksi.index', compact('lowongans'));
    }

    /**
     * Menjalankan perhitungan SAW dan menampilkan ranking.
     */
    public function show(Lowongan $lowongan)
    {
        // 1. Validasi: Ambil semua Lamaran yang sudah mengisi form SAW
        $lamarans = Lamaran::with(['pelamar', 'jawabanAdministrasi.skalaNilai'])
                           ->where('lowongan_id', $lowongan->id_lowongan)
                           ->whereIn('status', ['Proses Administrasi', 'Lolos Administrasi', 'Gagal Administrasi'])
                           ->get();
        
        // 2. Ambil Kriteria (W) dan Bobot dari Posisi
        $kriterias = $lowongan->posisi->kriteria()->get();

        if ($lamarans->isEmpty() || $kriterias->isEmpty()) {
            return back()->withErrors('Tidak ada pelamar yang memenuhi syarat atau Kriteria SAW belum diatur untuk posisi ini.');
        }

        // ======================================================
        // == LOGIKA PERHITUNGAN SAW ==
        // ======================================================
        $matriks_x = []; 
        $alternatif_ids = []; 

        // 3. Buat Matriks Keputusan (X)
        foreach ($lamarans as $lamaran) {
            $alternatif_ids[$lamaran->id_lamaran] = $lamaran->pelamar->nama;
            
            foreach ($kriterias as $kriteria) {
                $jawaban = $lamaran->jawabanAdministrasi->where('kriteria_id', $kriteria->id_kriteria)->first();
                $nilai_x = $jawaban ? $jawaban->skalaNilai->nilai : 0; 
                $matriks_x[$lamaran->id_lamaran][$kriteria->id_kriteria] = $nilai_x;
            }
        }

        // 4. Cari Nilai Max per Kriteria (Max(Xj))
        $max_values = [];
        foreach ($kriterias as $kriteria) {
            $values = array_column($matriks_x, $kriteria->id_kriteria);
            $max_values[$kriteria->id_kriteria] = $values ? max($values) : 1; 
        }

        // 5. Normalisasi Matriks (R)
        $matriks_r = $matriks_x;
        foreach ($matriks_r as $id_lamaran => $kriteria_list) {
            foreach ($kriteria_list as $id_kriteria => $nilai_x) {
                $pembagi = $max_values[$id_kriteria];
                $matriks_r[$id_lamaran][$id_kriteria] = $nilai_x / $pembagi;
            }
        }
        
        // 6. Hitung Nilai Preferensi (V)
        $hasil_v = [];
        foreach ($matriks_r as $id_lamaran => $kriteria_list) {
            $total_nilai = 0;
            foreach ($kriteria_list as $id_kriteria => $nilai_normal) {
                $bobot_w = $kriterias->where('id_kriteria', $id_kriteria)->first()->pivot->bobot_saw;
                $total_nilai += ($bobot_w * $nilai_normal);
            }
            $hasil_v[$id_lamaran] = round($total_nilai, 4);
        }

        // 7. Rangking
        arsort($hasil_v);

        // 8. Format Hasil Akhir untuk View
        $hasil_akhir = [];
        foreach ($hasil_v as $id_lamaran => $nilai_v) {
            $lamaran = $lamarans->where('id_lamaran', $id_lamaran)->first();
            $hasil_akhir[] = [
                'pelamar' => $lamaran->pelamar->nama,
                'status_lamaran' => $lamaran->status,
                'lamaran_id' => $id_lamaran,
                'nilai_v' => $nilai_v,
            ];
        }
        // ======================================================
        
        return view('admin.seleksi.show', compact('lowongan', 'hasil_akhir', 'kriterias'));
    }

    /**
     * Update status lamaran menjadi Lolos/Gagal Administrasi.
     * (Method ini sudah dipindahkan ke luar fungsi show())
     */
    public function updateStatus(Request $request, Lamaran $lamaran)
    {
        $request->validate([
            'status' => 'required|in:Lolos Administrasi,Gagal Administrasi',
        ]);
        
        $lamaran->status = $request->status;
        $lamaran->save();

        $pesan = $request->status == 'Lolos Administrasi' 
            ? 'Pelamar berhasil diloloskan ke tahap psikotes.' 
            : 'Pelamar berhasil digagalkan pada tahap administrasi.';

        return back()->with('success', $pesan);
    }
}