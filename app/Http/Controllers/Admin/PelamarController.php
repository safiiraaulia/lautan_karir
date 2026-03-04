<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelamar;
use Illuminate\Http\Request;

class PelamarController extends Controller
{

    public function index()
    {
        $pelamars = Pelamar::latest()->get();
        return view('admin.pelamar.index', compact('pelamars'));
    }

    public function show(Pelamar $pelamar)
    {
        return view('admin.pelamar.show', compact('pelamar'));
    }

    public function toggleStatus(Pelamar $pelamar)
    {
        $pelamar->is_active = !$pelamar->is_active;
        $pelamar->save();

        $status = $pelamar->is_active ? "diaktifkan" : "dinonaktifkan";

        return back()->with('success', "Akun pelamar '$pelamar->nama' berhasil $status.");
    }

    public function markRead()
    {
        \App\Models\Lamaran::where('pelamar_id', Auth::guard('pelamar')->id())
            ->whereIn('status', ['Lolos Seleksi', 'Gagal Seleksi'])
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}