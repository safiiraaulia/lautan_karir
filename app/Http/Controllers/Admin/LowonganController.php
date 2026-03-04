<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Posisi;
use App\Models\Dealer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LowonganController extends Controller
{
    public function index(Request $request)
{
    $isTrash = $request->has('trash');
    $query = Lowongan::with(['posisi', 'dealer']);

    if ($isTrash) {
        $lowongans = $query->onlyTrashed()->latest('deleted_at')->get();
    } else {
        $lowongans = $query->latest()->get();
    }

    return view('admin.lowongan.index', compact('lowongans', 'isTrash'));
    }

    public function create()
    {
        $posisis = Posisi::where('is_active', true)->orderBy('nama_posisi')->get();
        $dealers = Dealer::orderBy('nama_dealer')->get();
        return view('admin.lowongan.create', compact('posisis', 'dealers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'posisi_id' => 'required|exists:posisi,kode_posisi',
            'dealer_id' => 'required|exists:dealer,kode_dealer',
            'tgl_buka' => 'required|date',
            'tgl_tutup' => 'required|date|after_or_equal:tgl_buka',
            'status' => 'required|in:Buka,Tutup',
            'deskripsi' => 'nullable|string',
        ]);

        Lowongan::create($validated);
        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan baru berhasil ditambahkan.');
    }

    public function edit(Lowongan $lowongan)
    {
        $posisis = Posisi::where('is_active', true)->orderBy('nama_posisi')->get();
        $dealers = Dealer::orderBy('nama_dealer')->get();
        return view('admin.lowongan.edit', compact('lowongan', 'posisis', 'dealers'));
    }

    public function update(Request $request, Lowongan $lowongan)
    {
        $validated = $request->validate([
            'posisi_id' => 'required|exists:posisi,kode_posisi',
            'dealer_id' => 'required|exists:dealer,kode_dealer',
            'tgl_buka' => 'required|date',
            'tgl_tutup' => 'required|date|after_or_equal:tgl_buka',
            'status' => 'required|in:Buka,Tutup',
            'deskripsi' => 'nullable|string',
        ]);

        $lowongan->update($validated);
        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroy(Lowongan $lowongan)
    {
        $lowongan->delete();
        return back()->with('success', 'Lowongan dipindahkan ke tempat sampah.');
    }

    public function restore($id)
    {
        $lowongan = Lowongan::onlyTrashed()->findOrFail($id);
        $lowongan->restore();
        return redirect()->route('admin.lowongan.index')->with('success', 'Lowongan berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $lowongan = Lowongan::onlyTrashed()->findOrFail($id);
        DB::transaction(fn() => $lowongan->forceDelete());
        return back()->with('success', 'Lowongan dihapus permanen.');
    }
}