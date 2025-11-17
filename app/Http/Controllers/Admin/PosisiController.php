<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posisi;
use App\Models\Kriteria;
use App\Models\SkalaNilai;
use Illuminate\Http\Request;

class PosisiController extends Controller
{
    public function index()
    {
        // Ambil relasi kriteria (untuk count)
        $posisis = Posisi::withCount('kriteria')->orderBy('nama_posisi', 'asc')->get();
        return view('admin.posisi.index', compact('posisis'));
    }

    public function create()
    {
        // Form create tidak perlu data kriteria lagi
        return view('admin.posisi.create');
    }

    public function store(Request $request)
    {
        // Validasi HANYA untuk info posisi
        $request->validate([
            'kode_posisi' => 'required|string|max:10|unique:posisi,kode_posisi',
            'nama_posisi' => 'required|string|max:255',
            'level' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        Posisi::create($request->all());

        return redirect()->route('admin.posisi.index')
                         ->with('success', 'Posisi baru berhasil ditambahkan. Silakan atur kriteria & skala.');
    }

    public function edit(Posisi $posisi)
    {
        // Form edit tidak perlu data kriteria lagi
        return view('admin.posisi.edit', compact('posisi'));
    }

    /* ======================================================
    == METHOD BARU UNTUK HALAMAN SETUP SAW (SUDAH BENAR) ==
    ======================================================
    */
    public function setupSaw(Posisi $posisi)
    {
        $kriterias = Kriteria::orderBy('nama_kriteria')->get();

        $bobot_tersimpan = $posisi->kriteria()
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id_kriteria => $item->pivot->bobot_saw];
            })->toArray();

        $skala_tersimpan = SkalaNilai::where('posisi_id', $posisi->kode_posisi)
            ->get()
            ->groupBy('kriteria_id'); 

        return view('admin.posisi.setup_saw', compact(
            'posisi', 
            'kriterias', 
            'bobot_tersimpan', 
            'skala_tersimpan'
        ));
    }

    /**
     * Menyimpan data Bobot (W) dan Skala Nilai (Cij).
     */
    public function storeSaw(Request $request, Posisi $posisi)
    {
        $request->validate([
            'kriteria' => 'nullable|array', // Bobot (W)
            'skala' => 'nullable|array', // Skala Nilai (Cij)
        ]);

        // 1. Simpan Bobot Kriteria (W)
        if ($request->has('kriteria')) {
            $bobotData = [];
            foreach ($request->kriteria as $kriteria_id => $data) {
                if (!empty($data['bobot']) && $data['bobot'] > 0) {
                    $bobotData[$kriteria_id] = ['bobot_saw' => $data['bobot']];
                }
            }
            $posisi->kriteria()->sync($bobotData);
        } else {
            $posisi->kriteria()->sync([]);
        }

        // 2. Simpan Skala Nilai (Cij)
        SkalaNilai::where('posisi_id', $posisi->kode_posisi)->delete();
        
        if ($request->has('skala')) {
            $skalaData = [];
            foreach ($request->skala as $kriteria_id => $skalas) {
                foreach ($skalas as $skala) {
                    if (!empty($skala['deskripsi']) && isset($skala['nilai'])) {
                        $skalaData[] = [
                            'posisi_id' => $posisi->kode_posisi,
                            'kriteria_id' => $kriteria_id,
                            'deskripsi' => $skala['deskripsi'],
                            'nilai' => $skala['nilai'],
                        ];
                    }
                }
            }
            SkalaNilai::insert($skalaData);
        }

        return redirect()->route('admin.posisi.index')
                         ->with('success', 'Data Kriteria & Skala Nilai untuk ' . $posisi->nama_posisi . ' berhasil disimpan.');
    }
    /* ======================================================
    == BATAS METHOD BARU ==
    ======================================================
    */


    public function update(Request $request, Posisi $posisi)
    {
        // Validasi HANYA untuk info posisi
        $request->validate([
            'nama_posisi' => 'required|string|max:255',
            'level' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $posisi->update($request->only('nama_posisi', 'level', 'is_active'));

        return redirect()->route('admin.posisi.index')
                         ->with('success', 'Info Posisi berhasil diperbarui.');
    }

    public function destroy(Posisi $posisi)
    {
        $posisi->delete(); // Ini Soft Delete
        return redirect()->route('admin.posisi.index')
                         ->with('success', 'Posisi berhasil dihapus.');
    }
}