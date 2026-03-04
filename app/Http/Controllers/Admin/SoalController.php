<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SoalKelompok;
use App\Models\OpsiJawaban;
use App\Models\JenisTes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoalController extends Controller
{
    public function index()
    {
        $soals = SoalKelompok::with(['jenisTes', 'opsiJawaban'])
            ->orderBy('jenis_tes_id')
            ->orderBy('nomor_kelompok')
            ->get();

        return view('admin.soal.index', compact('soals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_tes_id' => 'required',
            'nomor_kelompok' => 'required|integer',
            'isi_opsi' => 'required|array',
            'isi_opsi.*' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Simpan Kelompok Soal
            $kelompok = SoalKelompok::create([
                'jenis_tes_id' => $request->jenis_tes_id,
                'nomor_kelompok' => $request->nomor_kelompok,
                'tipe_soal' => $request->jenis_tes_id == 1 ? 'disc' : 'papikostik',
            ]);

            // 2. Tentukan Label Otomatis
            $labels = ($request->jenis_tes_id == 1) ? ['D', 'I', 'S', 'C'] : ['A', 'B'];

            // 3. Simpan Opsi Jawaban
            foreach ($request->isi_opsi as $index => $teks) {
                OpsiJawaban::create([
                    'soal_id' => $kelompok->id_soal_kelompok,
                    'isi_opsi' => $teks,
                    'kode_aspek' => $labels[$index] ?? null,
                ]);
            }
        });

        return redirect()->route('admin.bank-soal.index')->with('success', 'Soal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $soal = SoalKelompok::with('opsiJawaban')->findOrFail($id);
        $jenisTes = JenisTes::all();
        return view('admin.soal.edit', compact('soal', 'jenisTes'));
    }

    public function update(Request $request, $id)
    {
        $soal = SoalKelompok::findOrFail($id);

        DB::transaction(function () use ($request, $soal) {
            $soal->update([
                'nomor_kelompok' => $request->nomor_kelompok
            ]);

            foreach ($request->opsi_id as $index => $oid) {
                OpsiJawaban::where('id_opsi_jawaban', $oid)->update([
                    'isi_opsi' => $request->isi_opsi[$index]
                ]);
            }
        });

        return redirect()->route('admin.bank-soal.index')->with('success', 'Soal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $soal = SoalKelompok::findOrFail($id);
        $soal->delete(); 
        return redirect()->route('admin.bank-soal.index')->with('success', 'Soal berhasil dihapus!');
    }
}