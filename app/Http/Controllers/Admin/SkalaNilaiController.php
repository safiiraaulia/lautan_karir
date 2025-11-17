<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkalaNilai;
use App\Models\Kriteria;
use App\Models\Posisi; // <-- TAMBAHKAN INI
use Illuminate\Http\Request;

class SkalaNilaiController extends Controller
{
    /**
     * Menampilkan daftar Skala Nilai.
     */
    public function index()
    {
        // FIX: Tambahkan relasi 'posisi'
        $skalaNilais = SkalaNilai::with(['kriteria', 'posisi'])->orderBy('id_skala', 'desc')->get();
        return view('admin.skala_nilai.index', compact('skalaNilais'));
    }

    /**
     * Menampilkan form untuk membuat Skala Nilai baru.
     */
    public function create()
    {
        // FIX: Ambil juga data Posisi
        $kriterias = Kriteria::orderBy('nama_kriteria')->get();
        $posisis = Posisi::orderBy('nama_posisi')->get(); // Ambil semua posisi
        return view('admin.skala_nilai.create', compact('kriterias', 'posisis'));
    }

    /**
     * Menyimpan Skala Nilai baru.
     */
    public function store(Request $request)
    {
        // FIX: Tambahkan validasi untuk 'posisi_id'
        $request->validate([
            'posisi_id' => 'required|exists:posisi,kode_posisi', // <-- TAMBAHKAN INI
            'kriteria_id' => 'required|exists:kriteria,id_kriteria',
            'deskripsi' => 'required|string|max:255',
            'nilai' => 'required|numeric',
        ]);

        SkalaNilai::create($request->all());

        return redirect()->route('admin.skala-nilai.index')
                         ->with('success', 'Skala Nilai berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit Skala Nilai.
     */
    public function edit(SkalaNilai $skalaNilai)
    {
        // FIX: Ambil juga data Posisi
        $kriterias = Kriteria::orderBy('nama_kriteria')->get();
        $posisis = Posisi::orderBy('nama_posisi')->get(); // Ambil semua posisi
        return view('admin.skala_nilai.edit', compact('skalaNilai', 'kriterias', 'posisis'));
    }

    /**
     * Update Skala Nilai.
     */
    public function update(Request $request, SkalaNilai $skalaNilai)
    {
        // FIX: Tambahkan validasi untuk 'posisi_id'
        $request->validate([
            'posisi_id' => 'required|exists:posisi,kode_posisi', // <-- TAMBAHKAN INI
            'kriteria_id' => 'required|exists:kriteria,id_kriteria',
            'deskripsi' => 'required|string|max:255',
            'nilai' => 'required|numeric',
        ]);

        $skalaNilai->update($request->all());

        return redirect()->route('admin.skala-nilai.index')
                         ->with('success', 'Skala Nilai berhasil diperbarui.');
    }

    /**
     * Hapus Skala Nilai.
     */
    public function destroy(SkalaNilai $skalaNilai)
    {
        $skalaNilai->delete();

        return redirect()->route('admin.skala-nilai.index')
                         ->with('success', 'Skala Nilai berhasil dihapus.');
    }
}