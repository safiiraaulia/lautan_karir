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
        $pelamar->load(['keluarga', 'pendidikan', 'pekerjaan']);
        return view('pelamar.profile', compact('pelamar'));
    }

    public function update(Request $request)
    {
        $pelamar = Auth::guard('pelamar')->user();
        // --- 1. VALIDASI DATA ---
        $rules = [
            'nama'                  => 'required|string|max:255',
            'no_ktp'                => 'required|numeric|digits:16',
            'kewarganegaraan'       => 'required',
            'tempat_lahir'          => 'required|string',
            'tanggal_lahir'         => 'required|date',
            'jenis_kelamin'         => 'required',
            'agama'                 => 'required|string',
            'golongan_darah'        => 'required',
            'tinggi_badan'          => 'required|numeric',
            'berat_badan'           => 'required|numeric',
            'alamat_domisili'       => 'required|string',
            'status_tempat_tinggal' => 'required',
            
            // Keluarga Wajib
            'status_pernikahan'     => 'required',
            'nama_ibu_kandung'      => 'required|string',
            
            // Kendaraan Opsional
            'jenis_kendaraan'       => 'nullable',
            'kepemilikan_kendaraan' => 'nullable',
            'merk_kendaraan'        => 'nullable',

            // Berkas Wajib (hanya wajib jika belum pernah upload)
            'foto'          => ($pelamar->foto          ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg|max:2048',
            'path_ktp'      => ($pelamar->path_ktp      ? 'nullable' : 'required') . '|mimes:pdf|max:2048',
            'path_cv'       => ($pelamar->path_cv       ? 'nullable' : 'required') . '|mimes:pdf|max:2048',
            'path_ijazah'   => ($pelamar->path_ijazah   ? 'nullable' : 'required') . '|mimes:pdf|max:2048',
            'path_kk'       => ($pelamar->path_kk       ? 'nullable' : 'required') . '|mimes:pdf|max:2048',
            'path_lamaran'  => ($pelamar->path_lamaran  ? 'nullable' : 'required') . '|mimes:pdf|max:2048',
            'path_transkrip' => 'nullable|mimes:pdf|max:2048',
        ];

        $request->validate($rules, [
            'required'      => ':attribute wajib diisi.',
            'no_ktp.digits' => 'Nomor KTP harus berjumlah tepat 16 digit.',
            'mimes'         => 'Format file :attribute harus sesuai ketentuan.',
        ]);

        DB::transaction(function () use ($request, $pelamar) {      
            // 2. SETUP DATA UTAMA
            $keysToExclude = [
                '_token', '_method', 
                'keluarga', 'pendidikan', 'pekerjaan', 
                'foto', 'path_cv', 'path_ktp', 'path_ijazah', 'path_kk', 'path_lamaran', 'path_transkrip',
                // 'status_vaksin',
            ];
            
            $dataPelamar = $request->except($keysToExclude);

            // 3. PROSES UPLOAD FILE
            $files = [
                'foto', 'path_cv', 'path_ktp', 'path_ijazah', 'path_kk', 'path_lamaran',
                'path_transkrip',
            ];

            foreach ($files as $fileKey) {
                if ($request->hasFile($fileKey)) {
                    if ($pelamar->$fileKey) {
                        Storage::disk('public')->delete($pelamar->$fileKey);
                    }
                    $path = $request->file($fileKey)->store('berkas_pelamar', 'public');
                    $dataPelamar[$fileKey] = $path;
                }
            }

            // 4. UPDATE DATA UTAMA
            $pelamar->update($dataPelamar);

            // 5. UPDATE DATA KELUARGA (Anak)
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

        return redirect()->route('pelamar.profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}