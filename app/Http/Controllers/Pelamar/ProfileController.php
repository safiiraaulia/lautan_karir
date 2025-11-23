<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // Pastikan ini ada
use App\Models\PelamarKeluarga;
use App\Models\PelamarPendidikan;
use App\Models\PelamarPekerjaan;

class ProfileController extends Controller
{
    public function edit()
    {
        $pelamar = Auth::guard('pelamar')->user();
        $pelamar->load(['keluarga', 'pendidikan', 'pekerjaan']);
        return view('pelamar.profile', compact('pelamar'));
    }

    public function update(Request $request)
    {
        $pelamar = Auth::guard('pelamar')->user();

        DB::transaction(function () use ($request, $pelamar) {
            
            // 1. SETUP DATA PELAMAR
            // PENTING: Kecualikan semua input file dan array dari data utama
            // agar tidak tersimpan sebagai object temporary (C:\Tmp\...)
            $keysToExclude = [
                '_token', '_method', 
                'keluarga', 'pendidikan', 'pekerjaan', // Array data anak
                'foto', 'path_cv', 'path_ktp', 'path_ijazah', 'path_kk', 'path_lamaran' // File
            ];
            
            $dataPelamar = $request->except($keysToExclude);
            
            // 2. PROSES UPLOAD FILE (Satu per Satu)
            $files = ['foto', 'path_cv', 'path_ktp', 'path_ijazah', 'path_kk', 'path_lamaran'];
            
            foreach ($files as $fileKey) {
                if ($request->hasFile($fileKey)) {
                    // Hapus file lama jika ada
                    if ($pelamar->$fileKey) {
                        Storage::disk('public')->delete($pelamar->$fileKey);
                    }
                    
                    // Upload file baru ke folder 'berkas_pelamar' di storage public
                    // store() akan mengembalikan path relatif (contoh: berkas_pelamar/namafile.jpg)
                    $path = $request->file($fileKey)->store('berkas_pelamar', 'public');
                    
                    // Masukkan path string ke array data untuk disimpan ke DB
                    $dataPelamar[$fileKey] = $path;
                }
            }

            // 3. UPDATE TABEL PELAMAR (Dengan path file yang benar)
            $pelamar->update($dataPelamar);

            // 4. UPDATE TABEL KELUARGA
            PelamarKeluarga::where('pelamar_id', $pelamar->id_pelamar)->delete();
            if ($request->has('keluarga')) {
                foreach ($request->keluarga as $row) {
                    if (!empty($row['nama'])) {
                        $pelamar->keluarga()->create($row);
                    }
                }
            }

            // 5. UPDATE TABEL PENDIDIKAN
            PelamarPendidikan::where('pelamar_id', $pelamar->id_pelamar)->delete();
            if ($request->has('pendidikan')) {
                foreach ($request->pendidikan as $row) {
                    if (!empty($row['nama_sekolah'])) {
                        $pelamar->pendidikan()->create($row);
                    }
                }
            }

            // 6. UPDATE TABEL PEKERJAAN
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
                         ->with('success', 'Profil berhasil diperbarui!');
    }
}