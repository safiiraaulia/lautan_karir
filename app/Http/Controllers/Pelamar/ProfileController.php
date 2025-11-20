<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PelamarKeluarga;
use App\Models\PelamarPendidikan;
use App\Models\PelamarPekerjaan;

class ProfileController extends Controller
{
    /**
     * Menampilkan formulir data diri pelamar.
     */
    public function edit()
    {
        $pelamar = Auth::guard('pelamar')->user();
        
        // Load data relasi agar muncul di form (jika sudah pernah diisi)
        $pelamar->load(['keluarga', 'pendidikan', 'pekerjaan']);

        return view('pelamar.profile', compact('pelamar'));
    }

    /**
     * Menyimpan perubahan profil.
     */
    public function update(Request $request)
    {
        $pelamar = Auth::guard('pelamar')->user();

        // Gunakan DB Transaction agar jika satu gagal, semua batal (Data aman)
        DB::transaction(function () use ($request, $pelamar) {
            
            // 1. UPDATE TABEL UTAMA (PELAMAR)
            // Kita ambil semua input, kecuali data array (keluarga/pendidikan/pekerjaan)
            // dan file upload (kita handle terpisah jika ada)
            $dataUtama = $request->except(['_token', '_method', 'keluarga', 'pendidikan', 'pekerjaan']);
            
            // Update data diri
            $pelamar->update($dataUtama);

            // 2. UPDATE DATA KELUARGA
            // Hapus data lama, masukkan data baru (Cara termudah untuk update data tabel dinamis)
            PelamarKeluarga::where('pelamar_id', $pelamar->id_pelamar)->delete();
            
            if ($request->has('keluarga')) {
                foreach ($request->keluarga as $row) {
                    // Hanya simpan jika nama tidak kosong
                    if (!empty($row['nama'])) {
                        $pelamar->keluarga()->create($row);
                    }
                }
            }

            // 3. UPDATE DATA PENDIDIKAN
            PelamarPendidikan::where('pelamar_id', $pelamar->id_pelamar)->delete();

            if ($request->has('pendidikan')) {
                foreach ($request->pendidikan as $row) {
                    if (!empty($row['nama_sekolah'])) {
                        $pelamar->pendidikan()->create($row);
                    }
                }
            }

            // 4. UPDATE DATA PEKERJAAN
            PelamarPekerjaan::where('pelamar_id', $pelamar->id_pelamar)->delete();

            if ($request->has('pekerjaan')) {
                foreach ($request->pekerjaan as $row) {
                    if (!empty($row['nama_perusahaan'])) {
                        $pelamar->pekerjaan()->create($row);
                    }
                }
            }
        });

        return redirect()->route('pelamar.profile.edit')
                         ->with('success', 'Profil berhasil diperbarui. Data Anda siap digunakan untuk melamar.');
    }
}