<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Lamaran;
use App\Models\JawabanAdministrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LamaranController extends Controller
{
    /**
     * Menampilkan Form Seleksi Administrasi (Pertanyaan SAW)
     */
    public function create(Lowongan $lowongan)
    {
        $pelamar = Auth::guard('pelamar')->user();

        // 1. Cek Kelengkapan Profil (VALIDASI BARU)
        // Pastikan Nama, No HP, KTP, dan CV sudah ada
        if (empty($pelamar->nama) || empty($pelamar->nomor_whatsapp) || empty($pelamar->no_ktp) || empty($pelamar->path_cv)) {
            return redirect()->route('pelamar.profile.edit')
                ->with('error', 'Harap lengkapi data diri (termasuk No. KTP) dan upload CV terlebih dahulu sebelum melamar.');
        }

        // 2. Cek apakah sudah pernah melamar di lowongan ini
        $cekLamaran = Lamaran::where('pelamar_id', $pelamar->id_pelamar)
                             ->where('lowongan_id', $lowongan->id_lowongan)
                             ->first();

        if ($cekLamaran) {
            return redirect()->route('pelamar.dashboard')
                ->with('error', 'Anda sudah pernah melamar posisi ini.');
        }

        // 3. Ambil Kriteria & Skala Nilai untuk Posisi ini
        $posisi = $lowongan->posisi;
        
        // Ambil kriteria yang terhubung ke posisi ini
        $kriterias = $posisi->kriteria()->get();

        // PENTING: Filter Skala Nilai
        // Kita harus memfilter pilihan jawaban (skala) agar HANYA muncul
        // pilihan yang relevan untuk Posisi ini (misal: nilai S1 untuk Admin IT beda dengan OB)
        foreach ($kriterias as $kriteria) {
            $kriteria->setRelation('skalaNilai', 
                $kriteria->skalaNilai()->where('posisi_id', $posisi->kode_posisi)->get()
            );
        }

        return view('pelamar.lamaran.create', compact('lowongan', 'kriterias'));
    }

    /**
     * Menyimpan Lamaran & Jawaban SAW
     */
    public function store(Request $request, Lowongan $lowongan)
    {
        $pelamar = Auth::guard('pelamar')->user();

        // Validasi: Pastikan semua pertanyaan kriteria dijawab
        $rules = [];
        foreach ($lowongan->posisi->kriteria as $kriteria) {
            $rules['kriteria_' . $kriteria->id_kriteria] = 'required';
        }
        $request->validate($rules, [], ['kriteria_*' => 'Pertanyaan kriteria']);

        DB::transaction(function () use ($request, $lowongan, $pelamar) {
            // 1. Buat Record Lamaran Baru
            $lamaran = Lamaran::create([
                'pelamar_id' => $pelamar->id_pelamar,
                'lowongan_id' => $lowongan->id_lowongan,
                'tgl_melamar' => now(),
                'status' => 'Proses Administrasi',
            ]);

            // 2. Simpan Jawaban SAW Pelamar
            foreach ($lowongan->posisi->kriteria as $kriteria) {
                $inputName = 'kriteria_' . $kriteria->id_kriteria;
                
                if ($request->has($inputName)) {
                    JawabanAdministrasi::create([
                        'lamaran_id' => $lamaran->id_lamaran,
                        'kriteria_id' => $kriteria->id_kriteria,
                        'skala_nilai_id' => $request->input($inputName), // ID Skala yang dipilih
                    ]);
                }
            }
        });

        return redirect()->route('pelamar.dashboard')
                         ->with('success', 'Lamaran berhasil dikirim! Data Anda sedang diseleksi oleh sistem.');
    }
}