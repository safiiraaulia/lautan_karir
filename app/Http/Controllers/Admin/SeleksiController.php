<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\JawabanTes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeleksiController extends Controller
{
    public function index() {
        $lowongans = Lowongan::with('posisi', 'dealer')->where('status', 'Buka')->latest()->get();
        return view('admin.seleksi.index', compact('lowongans'));
    }

    public function show(Lowongan $lowongan) {
        $lowongan->load('posisi.kriteria');
        $hasil_akhir = $this->hitungSaw($lowongan);
        $kriterias = $lowongan->posisi->kriteria;
        
        return view('admin.seleksi.show', compact('lowongan', 'hasil_akhir', 'kriterias'));
    }

    public function simpanRanking(Lowongan $lowongan) {
        $lowongan->load('posisi.kriteria');
        $hasil_akhir = $this->hitungSaw($lowongan);
        
        if (empty($hasil_akhir)) return back()->with('error', 'Data pelamar tidak ditemukan.');

        DB::transaction(function () use ($hasil_akhir) {
            foreach ($hasil_akhir as $item) {
                if ($item['nilai_v'] > 0) {
                Lamaran::where('id_lamaran', $item['lamaran_id'])->update([
                    'skor_akhir_saw' => $item['nilai_v']
                ]);
            }
        }
    });

        return back()->with('success', 'Hasil perankingan berhasil diperbarui!');
    }

    public function updateStatus(Request $request, Lamaran $lamaran) {
        $request->validate(['status' => 'required|in:Proses Seleksi,Lolos Seleksi,Gagal Seleksi']);
        $lamaran->update(['status' => $request->status, 'is_read' => false]);
        return back()->with('success', "Status diperbarui ke {$request->status}");
    }

    private function hitungSaw($lowongan) {
        $lamarans = Lamaran::with(['pelamar', 'jawaban'])
            ->where('lowongan_id', $lowongan->id_lowongan)
            ->get();
            
        $kriterias = $lowongan->posisi->kriteria;

        if ($lamarans->isEmpty() || $kriterias->isEmpty()) return [];

        $minMax = [];
        foreach ($kriterias as $kriteria) {
            $nilai_column = [];
            foreach ($lamarans as $lamaran) {
                $jawaban = $lamaran->jawaban->where('kriteria_id', $kriteria->id_kriteria)->first();
                $nilai_column[] = $jawaban ? (float)$jawaban->nilai : 0;
            }
            
            if ($kriteria->jenis == 'Benefit') {
                $val = max($nilai_column);
                $minMax[$kriteria->id_kriteria] = ($val == 0 ? 1 : $val);
            } else {
                $filtered = array_filter($nilai_column);
                $val = empty($filtered) ? 0 : min($filtered);
                $minMax[$kriteria->id_kriteria] = ($val == 0 ? 1 : $val);
            }
        }

        $hasil_v = [];
        foreach ($lamarans as $lamaran) {
            $total_nilai = 0;
            foreach ($kriterias as $kriteria) {
                $jawaban = $lamaran->jawaban->where('kriteria_id', $kriteria->id_kriteria)->first();
                $nilai_asli = $jawaban ? (float)$jawaban->nilai : 0;
                $pembagi = $minMax[$kriteria->id_kriteria];
                
                $normalisasi = ($kriteria->jenis == 'Benefit') 
                    ? ($nilai_asli / $pembagi) 
                    : ($nilai_asli > 0 ? $pembagi / $nilai_asli : 0);
                
                $bobot = (float)($kriteria->pivot->bobot_saw ?? 0);
                $total_nilai += ($normalisasi * $bobot);
            }
            $hasil_v[$lamaran->id_lamaran] = round($total_nilai, 4);
        }

        arsort($hasil_v);

        $final_data = [];
        foreach ($hasil_v as $id_lamaran => $skor) {
            $lamaran = $lamarans->where('id_lamaran', $id_lamaran)->first();
            $sudahTes = \App\Models\JawabanTes::where('pelamar_id', $lamaran->pelamar_id)->exists();
            
            $final_data[] = [
                'lamaran_id'     => $id_lamaran,
                'pelamar'        => $lamaran->pelamar->nama ?? 'Tanpa Nama',
                'status_lamaran' => $lamaran->status,
                'nilai_v'        => $skor,
                'nilai_disimpan' => (float)($lamaran->skor_akhir_saw ?? 0),
                'sudah_tes'      => $sudahTes
            ];
        }
        return $final_data;
    }
}