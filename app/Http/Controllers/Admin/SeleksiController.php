<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\Kriteria;
use App\Models\SkalaNilai;
use Illuminate\Http\Request;

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
        // 1. Validasi: Ambil semua Lamaran untuk lowongan ini (yang statusnya "Proses Administrasi" atau "Lolos Admin")
        $lamarans = Lamaran::with(['pelamar', 'jawabanAdministrasi.skalaNilai'])
                           ->where('lowongan_id', $lowongan->id_lowongan)
                           ->whereIn('status', ['Proses Administrasi', 'Lolos Administrasi', 'Gagal Administrasi']) // Ambil lamaran yang sudah mengisi form SAW
                           ->get();
        
        // 2. Ambil Kriteria (W) dan Bobot dari Posisi
        $kriterias = $lowongan->posisi->kriteria()->get();

        if ($lamarans->isEmpty() || $kriterias->isEmpty()) {
            return back()->withErrors('Tidak ada pelamar yang memenuhi syarat atau Kriteria SAW belum diatur untuk posisi ini.');
        }

        // ======================================================
        // == LOGIKA PERHITUNGAN SAW ==
        // ======================================================
        $matriks_x = []; // Matriks Nilai (X)
        $alternatif_ids = []; // [lamaran_id => nama_pelamar]

        // 3. Buat Matriks Keputusan (X) dan Bobot (W)
        foreach ($lamarans as $lamaran) {
            $alternatif_ids[$lamaran->id_lamaran] = $lamaran->pelamar->nama;
            
            foreach ($kriterias as $kriteria) {
                // Ambil jawaban pelamar untuk kriteria ini
                $jawaban = $lamaran->jawabanAdministrasi
                                   ->where('kriteria_id', $kriteria->id_kriteria)
                                   ->first();
                
                // Nilai X adalah nilai numerik dari SkalaNilai
                // Gunakan 0 jika tidak ada jawaban (opsional: bisa juga diabaikan)
                $nilai_x = $jawaban ? $jawaban->skalaNilai->nilai : 0; 
                $matriks_x[$lamaran->id_lamaran][$kriteria->id_kriteria] = $nilai_x;
            }
        }

        // 4. Cari Nilai Max per Kriteria (Max(Xj))
        $max_values = [];
        foreach ($kriterias as $kriteria) {
            // Ambil semua nilai X untuk kriteria tertentu di semua pelamar
            $values = array_column($matriks_x, $kriteria->id_kriteria);
            
            // Karena kita asumsikan semua kriteria di tahap ini adalah 'Benefit'
            // (Semakin tinggi nilai semakin baik), kita hanya perlu mencari nilai maksimum.
            // Catatan: Jika ada 'Cost', logika ini harus diperluas.
            $max_values[$kriteria->id_kriteria] = $values ? max($values) : 1; // Hindari pembagian nol
        }

        // 5. Normalisasi Matriks (R)
        $matriks_r = $matriks_x; // Copy struktur
        foreach ($matriks_r as $id_lamaran => $kriteria_list) {
            foreach ($kriteria_list as $id_kriteria => $nilai_x) {
                $pembagi = $max_values[$id_kriteria];
                
                // Normalisasi R = Xij / Max(Xj)
                // Kita abaikan pengecekan Benefit/Cost karena semua di tahap Administrasi biasanya Benefit
                $matriks_r[$id_lamaran][$id_kriteria] = $nilai_x / $pembagi;
            }
        }
        
        // 6. Hitung Nilai Preferensi (V)
        $hasil_v = [];
        foreach ($matriks_r as $id_lamaran => $kriteria_list) {
            $total_nilai = 0;
            foreach ($kriteria_list as $id_kriteria => $nilai_normal) {
                // Bobot W diambil dari pivot table kriteria_posisi
                $bobot_w = $kriterias->where('id_kriteria', $id_kriteria)->first()->pivot->bobot_saw;
                
                // V = Sum (W * R)
                $total_nilai += ($bobot_w * $nilai_normal);
            }
            $hasil_v[$id_lamaran] = round($total_nilai, 4); // Bulatkan 4 angka di belakang koma
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
        
        return view('admin.seleksi.show', compact('lowongan', 'hasil_akhir', 'kriterias'));
    }

    // Nanti kita tambahkan method untuk update status Lolos/Gagal di sini
}