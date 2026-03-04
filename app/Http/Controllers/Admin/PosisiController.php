<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posisi;
use App\Models\Kriteria;
use App\Models\SkalaNilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosisiController extends Controller
{
    public function index(Request $request)
    {
        $isTrash = $request->has('trash');
        
        $query = Posisi::withCount('kriteria');

        if ($isTrash) {
            $posisis = $query->onlyTrashed()->latest('deleted_at')->get();
        } else {
            $posisis = $query->orderBy('nama_posisi', 'asc')->get();
        }

        return view('admin.posisi.index', compact('posisis', 'isTrash'));
    }
    public function create()
    {
        return view('admin.posisi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_posisi' => 'required|string|max:10|unique:posisi,kode_posisi',
            'nama_posisi' => 'required|string|max:255',
            'level'       => 'nullable|string',
            'is_active'   => 'required|boolean',
        ]);

        Posisi::create($validated);

        return redirect()->route('admin.posisi.index')
            ->with('success', 'Posisi baru berhasil ditambahkan.');
    }

    public function edit(Posisi $posisi)
    {
        return view('admin.posisi.edit', compact('posisi'));
    }

    public function update(Request $request, Posisi $posisi)
    {
        $validated = $request->validate([
            'nama_posisi' => 'required|string|max:255',
            'level'       => 'nullable|string',
            'is_active'   => 'required|boolean',
        ]);

        $posisi->update($validated);

        return redirect()->route('admin.posisi.index')
            ->with('success', 'Info Posisi berhasil diperbarui.');
    }

    public function destroy(Posisi $posisi)
    {
        $posisi->delete();
        return back()->with('success', 'Posisi berhasil dipindahkan ke tempat sampah.');
    }

    public function restore($id)
    {
        $posisi = Posisi::onlyTrashed()->findOrFail($id);
        $posisi->restore();
        return redirect()->route('admin.posisi.index')->with('success', 'Posisi berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $posisi = Posisi::onlyTrashed()->findOrFail($id);
        
        DB::transaction(function () use ($posisi) {
            $posisi->kriteria()->detach();
            SkalaNilai::where('posisi_id', $posisi->kode_posisi)->delete();
            $posisi->forceDelete();
        });

        return back()->with('success', 'Posisi dihapus permanen.');
    }
    
//SAW CONFIGURATION
    public function setupSaw(Posisi $posisi)
    {
        $kriterias = Kriteria::orderBy('nama_kriteria')->get();

        $pivot_tersimpan = $posisi->kriteria->mapWithKeys(function ($item) {
            return [$item->id_kriteria => [
                'bobot'  => $item->pivot->bobot_saw,
                'syarat' => $item->pivot->syarat
            ]];
        })->toArray();

        $skala_tersimpan = SkalaNilai::where('posisi_id', $posisi->kode_posisi)
            ->get()
            ->groupBy('kriteria_id'); 

        return view('admin.posisi.setup_saw', compact('posisi', 'kriterias', 'pivot_tersimpan', 'skala_tersimpan'));
    }

    public function storeSaw(Request $request, Posisi $posisi)
    {
        $request->validate([
            'kriteria' => 'nullable|array',
            'skala'    => 'nullable|array',
        ]);

        // Validasi Total Bobot 
        $totalBobot = collect($request->kriteria)->whereNotNull('id')->sum('bobot');

        if (abs($totalBobot - 1) > 0.001) {
            return back()->withInput()->with('error', "Gagal: Total Bobot harus 1. Saat ini: $totalBobot");
        }

        DB::transaction(function () use ($request, $posisi) {
            // 1. Sync Bobot & Syarat
            $pivotData = collect($request->kriteria)->filter(fn($data) => isset($data['id']) && !empty($data['bobot']))
                ->mapWithKeys(fn($data, $id) => [$id => [
                    'bobot_saw' => $data['bobot'], 'syarat' => $data['syarat'] ?? null
                ]])->toArray();

            $posisi->kriteria()->sync($pivotData);

            // 2. Simpan Skala Nilai (1-5)
            SkalaNilai::where('posisi_id', $posisi->kode_posisi)->delete();
            
            $skalaData = [];
            foreach ($request->skala ?? [] as $kriteria_id => $skalas) {
                if (isset($request->kriteria[$kriteria_id]['id'])) {
                    foreach ($skalas as $s) {
                        if (!empty($s['deskripsi']) && ($s['nilai'] >= 1 && $s['nilai'] <= 5)) {
                            $skalaData[] = [
                                'posisi_id'   => $posisi->kode_posisi,
                                'kriteria_id' => $kriteria_id,
                                'deskripsi'   => $s['deskripsi'],
                                'nilai'       => (int) $s['nilai'],
                            ];
                        }
                    }
                }
            }
            if (!empty($skalaData)) SkalaNilai::insert($skalaData);
        });

        return redirect()->route('admin.posisi.index')->with('success', 'Konfigurasi SAW diperbarui.');
    }
}