<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\PelamarKeluarga;
use App\Models\PelamarPendidikan;
use App\Models\PelamarPekerjaan;

class ProfileController extends Controller
{
    public function edit()
    {
        $pelamar = Auth::guard('pelamar')->user();
        // Load relasi agar data keluarga, pendidikan, pekerjaan muncul di form
        $pelamar->load(['keluarga', 'pendidikan', 'pekerjaan']);
        return view('pelamar.profile', compact('pelamar'));
    }

    public function update(Request $request)
    {
        $pelamar = Auth::guard('pelamar')->user();

        // --- 1. VALIDASI DATA ---
        // Tambahkan validasi untuk mencegah error SQL (Data too long)
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_ktp' => 'required|numeric|digits:16', // <-- PENTING: Wajib 16 digit
            'foto' => 'nullable|image|max:2048',       // Maks 2MB
            'path_cv' => 'nullable|mimes:pdf|max:2048',
            // Tambahkan validasi lain sesuai kebutuhan
        ], [
            'no_ktp.digits' => 'Nomor KTP harus berjumlah tepat 16 digit.',
            'no_ktp.numeric' => 'Nomor KTP harus berupa angka.',
        ]);

        DB::transaction(function () use ($request, $pelamar) {
            
            // 2. SETUP DATA UTAMA
            // Kecualikan input file dan array relasi agar tidak masuk ke update massal
            $keysToExclude = [
                '_token', '_method', 
                'keluarga', 'pendidikan', 'pekerjaan', // Data relasi (array)
                'foto', 'path_cv', 'path_ktp', 'path_ijazah', 'path_kk', 'path_lamaran' // Input File
            ];
            
            // Ambil semua data request kecuali yang di-exclude
            $dataPelamar = $request->except($keysToExclude);
            
            // 3. PROSES UPLOAD FILE (Looping)
            $files = ['foto', 'path_cv', 'path_ktp', 'path_ijazah', 'path_kk', 'path_lamaran'];
            
            foreach ($files as $fileKey) {
                if ($request->hasFile($fileKey)) {
                    // Hapus file lama dari storage jika ada
                    if ($pelamar->$fileKey) {
                        Storage::disk('public')->delete($pelamar->$fileKey);
                    }
                    
                    // Upload file baru & simpan path-nya
                    $path = $request->file($fileKey)->store('berkas_pelamar', 'public');
                    $dataPelamar[$fileKey] = $path;
                }
            }

            // 4. UPDATE DATA PELAMAR
            $pelamar->update($dataPelamar);

            // 5. UPDATE DATA KELUARGA (Hapus lama -> Buat baru)
            PelamarKeluarga::where('pelamar_id', $pelamar->id_pelamar)->delete();
            if ($request->has('keluarga')) {
                foreach ($request->keluarga as $row) {
                    if (!empty($row['nama'])) {
                        $pelamar->keluarga()->create($row);
                    }
                }
            }

            // 6. UPDATE DATA PENDIDIKAN
            PelamarPendidikan::where('pelamar_id', $pelamar->id_pelamar)->delete();
            if ($request->has('pendidikan')) {
                foreach ($request->pendidikan as $row) {
                    if (!empty($row['nama_sekolah'])) {
                        $pelamar->pendidikan()->create($row);
                    }
                }
            }

            // 7. UPDATE DATA PEKERJAAN
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