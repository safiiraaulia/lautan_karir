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
    /* ======================================================
       UPDATE BAGIAN INI DI PosisiController.php
       ====================================================== */

    public function setupSaw(Posisi $posisi)
    {
        $kriterias = Kriteria::orderBy('nama_kriteria')->get();

        // UBAH DISINI: Kita ambil Bobot DAN Syarat sekaligus
        $pivot_tersimpan = $posisi->kriteria()
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id_kriteria => [
                    'bobot'  => $item->pivot->bobot_saw,
                    'syarat' => $item->pivot->syarat // <-- Tambahan baru
                ]];
            })->toArray();

        $skala_tersimpan = SkalaNilai::where('posisi_id', $posisi->kode_posisi)
            ->get()
            ->groupBy('kriteria_id'); 

        // Variable dikirim ke view sebagai 'pivot_tersimpan'
        return view('admin.posisi.setup_saw', compact(
            'posisi', 
            'kriterias', 
            'pivot_tersimpan', 
            'skala_tersimpan'
        ));
    }

    public function storeSaw(Request $request, Posisi $posisi)
    {
        $request->validate([
            'kriteria' => 'nullable|array',
            'skala' => 'nullable|array',
        ]);

        // 1. Validasi Total Bobot (Logic tetap sama)
        $totalBobot = 0;
        if ($request->has('kriteria')) {
            foreach ($request->kriteria as $id => $data) {
                if (isset($data['id']) && isset($data['bobot'])) {
                    $totalBobot += (float) $data['bobot'];
                }
            }
        }

        if (abs($totalBobot - 1) > 0.001) {
            return back()
                ->withInput()
                ->with('error', 'Gagal Menyimpan: Total Bobot (W) harus berjumlah 1. Total saat ini: ' . $totalBobot);
        }

        // 2. Simpan Data Pivot (Bobot & Syarat)
        if ($request->has('kriteria')) {
            $pivotData = [];
            foreach ($request->kriteria as $kriteria_id => $data) {
                // Hanya simpan yang dicentang
                if (isset($data['id']) && !empty($data['bobot'])) {
                    $pivotData[$kriteria_id] = [
                        'bobot_saw' => $data['bobot'],
                        'syarat'    => $data['syarat'] ?? null // <-- Simpan Syarat disini
                    ];
                }
            }
            // Sync data ke tabel kriteria_posisi
            $posisi->kriteria()->sync($pivotData);
        } else {
            $posisi->kriteria()->sync([]);
        }

        // 3. Simpan Skala Nilai (Logic tetap sama)
        SkalaNilai::where('posisi_id', $posisi->kode_posisi)->delete();
        
        if ($request->has('skala')) {
            $skalaData = [];
            foreach ($request->skala as $kriteria_id => $skalas) {
                if (isset($request->kriteria[$kriteria_id]['id'])) {
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
            }
            if(!empty($skalaData)) {
                SkalaNilai::insert($skalaData);
            }
        }

        return redirect()->route('admin.posisi.index')
                         ->with('success', 'Kriteria, Bobot, dan Syarat berhasil disimpan.');
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