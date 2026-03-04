<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KriteriaController extends Controller
{
    public function index(Request $request)
    {
        $isTrash = $request->has('trash');
        $query = Kriteria::query();

        if ($isTrash) {
            $kriterias = $query->onlyTrashed()->latest('deleted_at')->get();
        } else {
            $kriterias = $query->orderBy('nama_kriteria', 'ASC')->get();
        }

        return view('admin.kriteria.index', compact('kriterias', 'isTrash'));
    }

    public function create()
    {
        return view('admin.kriteria.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'pertanyaan'    => 'required|string|max:500',
            'jenis'         => 'required|in:Benefit,Cost',
        ]);

        Kriteria::create($validated);
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function edit(Kriteria $kriteria)
    {
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $validated = $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'jenis'         => 'required|in:Benefit,Cost',
            'pertanyaan'    => 'required|string|max:500',
        ]);

        $kriteria->update($validated);
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Kriteria $kriteria)
    {
        $kriteria->delete();
        return back()->with('success', 'Kriteria dipindahkan ke tempat sampah.');
    }

    public function restore($id)
    {
        $kriteria = Kriteria::onlyTrashed()->findOrFail($id);
        $kriteria->restore();
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $kriteria = Kriteria::onlyTrashed()->findOrFail($id);
        
        DB::transaction(function () use ($kriteria) {
            $kriteria->posisi()->detach();
            $kriteria->skalaNilai()->delete();
            $kriteria->forceDelete();
        });

        return back()->with('success', 'Kriteria dihapus permanen.');
    }
}