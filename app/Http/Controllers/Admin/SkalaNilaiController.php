<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkalaNilai;
use App\Models\Kriteria;
use App\Models\Posisi; // <-- TAMBAHKAN INI
use Illuminate\Http\Request;

class SkalaNilaiController extends Controller
{

    public function index()
    {
        $skalaNilais = SkalaNilai::with(['kriteria', 'posisi'])->orderBy('id_skala', 'desc')->get();
        return view('admin.skala_nilai.index', compact('skalaNilais'));
    }

    public function create()
    {
        $kriterias = Kriteria::orderBy('nama_kriteria')->get();
        $posisis = Posisi::orderBy('nama_posisi')->get(); 
        return view('admin.skala_nilai.create', compact('kriterias', 'posisis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'posisi_id' => 'required|exists:posisi,kode_posisi',
            'kriteria_id' => 'required|exists:kriteria,id_kriteria',
            'deskripsi' => 'required|string|max:255',
            'nilai' => 'required|numeric',
        ]);

        SkalaNilai::create($request->all());

        return redirect()->route('admin.skala-nilai.index')
                         ->with('success', 'Skala Nilai berhasil ditambahkan.');
    }


    public function edit(SkalaNilai $skalaNilai)
    {
        $kriterias = Kriteria::orderBy('nama_kriteria')->get();
        $posisis = Posisi::orderBy('nama_posisi')->get(); // Ambil semua posisi
        return view('admin.skala_nilai.edit', compact('skalaNilai', 'kriterias', 'posisis'));
    }

    public function update(Request $request, SkalaNilai $skalaNilai)
    {
        $request->validate([
            'posisi_id' => 'required|exists:posisi,kode_posisi', 
            'kriteria_id' => 'required|exists:kriteria,id_kriteria',
            'deskripsi' => 'required|string|max:255',
            'nilai' => 'required|numeric',
        ]);

        $skalaNilai->update($request->all());

        return redirect()->route('admin.skala-nilai.index')
                         ->with('success', 'Skala Nilai berhasil diperbarui.');
    }

    public function destroy(SkalaNilai $skalaNilai)
    {
        $skalaNilai->delete();

        return redirect()->route('admin.skala-nilai.index')
                         ->with('success', 'Skala Nilai berhasil dihapus.');
    }
}