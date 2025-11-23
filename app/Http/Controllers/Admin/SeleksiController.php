<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Lamaran;
use Illuminate\Http\Request;

class SeleksiController extends Controller
{
    public function index()
    {
        $lowongans = Lowongan::with('posisi', 'dealer')
                             ->where('status', 'Buka')
                             ->latest()
                             ->get();
        return view('admin.seleksi.index', compact('lowongans'));
    }

    // Method untuk melihat hasil (Preview)
    public function show(Lowongan $lowongan)
    {
        $hasil_akhir = $this->hitungSaw($lowongan);
        $kriterias = $lowongan->posisi->kriteria()->get();

        return view('admin.seleksi.show', compact('lowongan', 'hasil_akhir', 'kriterias'));
    }

    // FITUR BARU: Simpan Hasil Perhitungan ke Database
    public function simpanRanking(Lowongan $lowongan)
    {
        // 1. Hitung ulang SAW (untuk memastikan data terbaru)
        $hasil_akhir = $this->hitungSaw($lowongan);

        if (empty($hasil_akhir)) {
            return back()->with('error', 'Tidak ada data pelamar untuk disimpan.');
        }

        // 2. Loop dan Update setiap lamaran
        foreach ($hasil_akhir as $item) {
            Lamaran::where('id_lamaran', $item['lamaran_id'])->update([
                'nilai_saw' => $item['nilai_v']
            ]);
        }

        return back()->with('success', 'Hasil perankingan SAW berhasil disimpan ke database!');
    }

    public function updateStatus(Request $request, Lamaran $lamaran)
    {
        $request->validate(['status' => 'required']);
        $lamaran->update(['status' => $request->status]);
        return back()->with('success', 'Status lamaran diperbarui.');
    }

    // --- PRIVATE FUNCTION: LOGIKA INTI SAW ---
    private function hitungSaw($lowongan)
    {
        // 1. Ambil Pelamar
        $lamarans = Lamaran::with(['pelamar', 'jawabanAdministrasi.skalaNilai'])
                           ->where('lowongan_id', $lowongan->id_lowongan)
                           ->whereIn('status', ['Proses Administrasi', 'Lolos Administrasi', 'Gagal Administrasi'])
                           ->get();
        
        $kriterias = $lowongan->posisi->kriteria()->get();

        if ($lamarans->isEmpty() || $kriterias->isEmpty()) {
            return [];
        }

        // 2. Buat Matriks Keputusan (X)
        $matriks_x = [];
        foreach ($lamarans as $lamaran) {
            foreach ($kriterias as $kriteria) {
                $jawaban = $lamaran->jawabanAdministrasi->where('kriteria_id', $kriteria->id_kriteria)->first();
                $nilai = $jawaban ? $jawaban->skalaNilai->nilai : 0;
                $matriks_x[$lamaran->id_lamaran][$kriteria->id_kriteria] = $nilai;
            }
        }

        // 3. Cari Max Nilai (Normalisasi)
        $max_values = [];
        foreach ($kriterias as $kriteria) {
            $col = array_column($matriks_x, $kriteria->id_kriteria);
            $max_values[$kriteria->id_kriteria] = $col ? max($col) : 1;
        }

        // 4. Hitung Nilai V (Preferensi)
        $hasil_v = [];
        foreach ($matriks_x as $id_lamaran => $nilai_kriterias) {
            $total = 0;
            foreach ($nilai_kriterias as $id_kriteria => $nilai) {
                $pembagi = $max_values[$id_kriteria];
                $bobot = $kriterias->where('id_kriteria', $id_kriteria)->first()->pivot->bobot_saw;
                // Rumus SAW: (Nilai / Max) * Bobot
                $total += ($nilai / $pembagi) * $bobot;
            }
            $hasil_v[$id_lamaran] = round($total, 4);
        }

        // 5. Ranking
        arsort($hasil_v);

        // 6. Format Data Kembali
        $final_data = [];
        foreach ($hasil_v as $id_lamaran => $skor) {
            $lamaran = $lamarans->where('id_lamaran', $id_lamaran)->first();
            $final_data[] = [
                'lamaran_id' => $id_lamaran,
                'pelamar' => $lamaran->pelamar->nama,
                'status_lamaran' => $lamaran->status,
                'nilai_v' => $skor,
                // Ambil nilai yang tersimpan di DB (jika ada) untuk cek sinkronisasi
                'nilai_disimpan' => $lamaran->nilai_saw 
            ];
        }

        return $final_data;
    }
}