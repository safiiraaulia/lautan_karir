<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Lamaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    // Preview hasil ranking
    public function show(Lowongan $lowongan)
    {
        $hasil_akhir = $this->hitungSaw($lowongan);
        $kriterias = $lowongan->posisi->kriteria()->get();

        return view('admin.seleksi.show', compact('lowongan', 'hasil_akhir', 'kriterias'));
    }

    // Simpan hasil perankingan
    public function simpanRanking(Lowongan $lowongan)
    {
        $hasil_akhir = $this->hitungSaw($lowongan);

        if (empty($hasil_akhir)) {
            return back()->with('error', 'Tidak ada data pelamar yang memenuhi kriteria hitung.');
        }

        foreach ($hasil_akhir as $item) {
            Lamaran::where('id_lamaran', $item['lamaran_id'])->update([
                'nilai_saw' => $item['nilai_v']
            ]);
        }

        return back()->with('success', 'Hasil perankingan SAW berhasil disimpan!');
    }

    // =========================
    // UPDATE STATUS PELAMAR (Sudah disesuaikan)
    // =========================
    public function updateStatus(Request $request, Lamaran $lamaran)
    {
        $request->validate([
            'status' => 'required|in:Proses Seleksi,Lolos Seleksi,Gagal Seleksi'
        ]);

        $lamaran->update([
            'status'   => $request->status,
            'is_read'  => false,
        ]);

        return back()->with('success', "Status pelamar berhasil diubah menjadi {$request->status}");
    }

    // =========================
    // LOGIKA SAW (STATUS SUDAH DISESUAIKAN)
    // =========================
    private function hitungSaw($lowongan)
    {
        // Ambil semua lamaran di lowongan ini tanpa filter status
        $lamarans = Lamaran::with(['pelamar', 'jawaban'])
                        ->where('lowongan_id', $lowongan->id_lowongan)
                        ->get();

        $kriterias = $lowongan->posisi->kriteria()->get();

        if ($lamarans->isEmpty() || $kriterias->isEmpty()) {
            return [];
        }

        // Ambil nilai MIN/MAX tiap kriteria
        $minMax = [];
        foreach ($kriterias as $kriteria) {

            $nilai_column = [];
            foreach ($lamarans as $lamaran) {
                $jawaban = $lamaran->jawaban->where('kriteria_id', $kriteria->id_kriteria)->first();
                $nilai_column[] = $jawaban ? $jawaban->nilai : 0;
            }

            if ($kriteria->jenis == 'Benefit') {
                $max = empty($nilai_column) ? 0 : max($nilai_column);
                $minMax[$kriteria->id_kriteria] = ($max == 0 ? 1 : $max);
            } else {
                $filtered = array_filter($nilai_column);
                $min = empty($filtered) ? 0 : min($filtered);
                $minMax[$kriteria->id_kriteria] = ($min == 0 ? 1 : $min);
            }
        }

        // Hitung nilai V
        $hasil_v = [];
        foreach ($lamarans as $lamaran) {
            $total_nilai = 0;

            foreach ($kriterias as $kriteria) {
                $jawaban = $lamaran->jawaban->where('kriteria_id', $kriteria->id_kriteria)->first();
                $nilai_asli = $jawaban ? $jawaban->nilai : 0;
                $pembagi = $minMax[$kriteria->id_kriteria];

                $normalisasi = 0;
                if ($kriteria->jenis == 'Benefit') {
                    $normalisasi = $nilai_asli / $pembagi;
                } else {
                    if ($nilai_asli > 0) {
                        $normalisasi = $pembagi / $nilai_asli;
                    }
                }

                $bobot = $kriteria->pivot->bobot_saw ?? 0;
                $total_nilai += ($normalisasi * $bobot);
            }

            $hasil_v[$lamaran->id_lamaran] = round($total_nilai, 4);
        }

        // Urutkan hasil SAW descending
        arsort($hasil_v);

        // Format pengembalian untuk Blade
        $final_data = [];
        foreach ($hasil_v as $id_lamaran => $skor) {
            $lamaran = $lamarans->where('id_lamaran', $id_lamaran)->first();
            $final_data[] = [
                'lamaran_id'     => $id_lamaran,
                'pelamar'        => $lamaran->pelamar->nama ?? 'Tanpa Nama',
                'status_lamaran' => $lamaran->status,
                'nilai_v'        => $skor,
                'nilai_disimpan' => $lamaran->nilai_saw
            ];
        }

        return $final_data;
    }

}
