<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelamar; // <-- Jangan lupa use Model
use Illuminate\Http\Request;

class PelamarController extends Controller
{
    /**
     * Menampilkan daftar semua pelamar.
     */
    public function index()
    {
        // Ambil semua data pelamar, urutkan dari yang terbaru
        $pelamars = Pelamar::latest()->get();
        return view('admin.pelamar.index', compact('pelamars'));
    }

    public function show(Pelamar $pelamar)
    {
        // $pelamar sudah otomatis diambil dari ID di URL
        return view('admin.pelamar.show', compact('pelamar'));
    }

    /**
     * Mengubah status aktif/non-aktif akun pelamar.
     */
    public function toggleStatus(Pelamar $pelamar)
    {
        // Ubah status is_active (dari true ke false, atau false ke true)
        $pelamar->is_active = !$pelamar->is_active;
        $pelamar->save();

        $status = $pelamar->is_active ? "diaktifkan" : "dinonaktifkan";

        return back()->with('success', "Akun pelamar '$pelamar->nama' berhasil $status.");
    }
}