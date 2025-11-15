<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posisi;

class PosisiController extends Controller
{
    public function index()
    {
        $posisi = Posisi::orderBy('id_posisi', 'ASC')->get();
        return view('admin.posisi.index', compact('posisi'));
    }

    public function create()
    {
        return view('admin.posisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_posisi' => 'required',
            'level' => 'nullable'
        ]);

        Posisi::create([
            'nama_posisi' => $request->nama_posisi,
            'level' => $request->level
        ]);

        return redirect()->route('admin.posisi.index')->with('success', 'Posisi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $posisi = Posisi::findOrFail($id);
        return view('admin.posisi.edit', compact('posisi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_posisi' => 'required',
            'level' => 'nullable'
        ]);

        Posisi::findOrFail($id)->update([
            'nama_posisi' => $request->nama_posisi,
            'level' => $request->level
        ]);

        return redirect()->route('admin.posisi.index')->with('success', 'Posisi berhasil diperbarui');
    }

    public function destroy($id)
    {
        Posisi::findOrFail($id)->delete();

        return redirect()->route('admin.posisi.index')->with('success', 'Posisi berhasil dihapus');
    }
}
