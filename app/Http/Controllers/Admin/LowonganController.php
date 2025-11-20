<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Posisi;
use App\Models\Dealer;
use App\Models\PaketTes;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    /**
     * Menampilkan daftar semua lowongan.
     */
    public function index()
    {
        // Ambil lowongan beserta relasi Posisi dan Dealer
        $lowongans = Lowongan::with(['posisi', 'dealer'])->latest()->get();
        return view('admin.lowongan.index', compact('lowongans'));
    }

    /**
     * Menampilkan form untuk membuat lowongan baru.
     */
    public function create()
    {
        // Ambil data master untuk dropdown
        $posisis = Posisi::where('is_active', true)->orderBy('nama_posisi')->get();
        $dealers = Dealer::orderBy('nama_dealer')->get();
        $paketTes = PaketTes::orderBy('nama_paket')->get(); // Ganti nama model jika beda

        return view('admin.lowongan.create', compact('posisis', 'dealers', 'paketTes'));
    }

    /**
     * Menyimpan lowongan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'posisi_id' => 'required|exists:posisi,kode_posisi',
            'dealer_id' => 'required|exists:dealer,kode_dealer',
            'tgl_buka' => 'required|date',
            'tgl_tutup' => 'required|date|after_or_equal:tgl_buka',
            'status' => 'required|in:Buka,Tutup',
            'deskripsi' => 'nullable|string',
        ]);

        Lowongan::create($request->all());

        return redirect()->route('admin.lowongan.index')
                         ->with('success', 'Lowongan baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail lowongan (opsional, bisa diskip).
     */
    public function show(Lowongan $lowongan)
    {
         // Load relasi agar bisa ditampilkan di view
        $lowongan->load(['posisi', 'dealer', 'paketTes']);
        return view('admin.lowongan.show', compact('lowongan'));
    }

    /**
     * Menampilkan form untuk mengedit lowongan.
     */
    public function edit(Lowongan $lowongan)
    {
        // Ambil data master untuk dropdown
        $posisis = Posisi::where('is_active', true)->orderBy('nama_posisi')->get();
        $dealers = Dealer::orderBy('nama_dealer')->get();
        $paketTes = PaketTes::orderBy('nama_paket')->get();

        return view('admin.lowongan.edit', compact('lowongan', 'posisis', 'dealers', 'paketTes'));
    }

    /**
     * Update lowongan yang ada.
     */
    public function update(Request $request, Lowongan $lowongan)
    {
        $request->validate([
            'posisi_id' => 'required|exists:posisi,kode_posisi',
            'dealer_id' => 'required|exists:dealer,kode_dealer',
            'tgl_buka' => 'required|date',
            'tgl_tutup' => 'required|date|after_or_equal:tgl_buka',
            'status' => 'required|in:Buka,Tutup',
            'deskripsi' => 'nullable|string',
        ]);

        $lowongan->update($request->all());

        return redirect()->route('admin.lowongan.index')
                         ->with('success', 'Lowongan berhasil diperbarui.');
    }

    /**
     * Hapus lowongan (soft delete).
     */
    public function destroy(Lowongan $lowongan)
    {
        $lowongan->delete(); // Ini akan melakukan soft delete

        return redirect()->route('admin.lowongan.index')
                         ->with('success', 'Lowongan berhasil dihapus.');
    }
}