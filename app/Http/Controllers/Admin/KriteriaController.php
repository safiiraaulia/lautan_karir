<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria; // <-- Pastikan Model Kriteria di-use
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Menampilkan daftar kriteria.
     */
    public function index()
    {
        $kriterias = Kriteria::all();
        // Buat folder 'kriteria' di dalam 'resources/views/admin/'
        return view('admin.kriteria.index', compact('kriterias'));
    }

    /**
     * Menampilkan form untuk membuat kriteria baru.
     */
    public function create()
    {
        return view('admin.kriteria.create');
    }

    /**
     * Menyimpan kriteria baru ke database.
     */
    public function store(Request $request)
    {
       $validatedData = $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'jenis' => 'required|in:Benefit,Cost',
            'bobot_saw' => 'required|numeric|min:0', // Pastikan validasi Anda ada
        ]);

        Kriteria::create($validatedData);

        return redirect()->route('admin.kriteria.index')
                         ->with('success', 'Kriteria berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit kriteria.
     */
    public function edit(Kriteria $kriteria)
    {
        // $kriteria adalah model Kriteria yang diambil otomatis oleh Laravel
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    /**
     * Update kriteria di database.
     */
    public function update(Request $request, Kriteria $kriteria)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'jenis' => 'required|in:Benefit,Cost',
            'bobot_saw' => 'required|numeric|min:0', // Pastikan validasi Anda ada
        ]);

        $kriteria->update($validatedData);

        return redirect()->route('admin.kriteria.index')
                         ->with('success', 'Kriteria berhasil diperbarui.');
    }

    /**
     * Hapus kriteria dari database.
     */
    public function destroy(Kriteria $kriteria)
    {
        $kriteria->delete();

        return redirect()->route('admin.kriteria.index')
                         ->with('success', 'Kriteria berhasil dihapus.');
    }
}