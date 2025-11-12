<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PelamarRegisterController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // Redirect jika sudah login
        $this->middleware('guest:pelamar');
    }

    /**
     * Tampilkan form register
     */
    public function showRegistrationForm()
    {
        return view('auth.pelamar-register');
    }

    /**
     * Proses register
     */
    public function register(Request $request)
    {
        // Validasi
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:pelamar,username',
            'email' => 'required|string|email|max:255|unique:pelamar,email',
            'nomor_whatsapp' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Buat pelamar baru
        $pelamar = Pelamar::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'nomor_whatsapp' => $request->nomor_whatsapp,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        // Auto-login setelah register
        Auth::guard('pelamar')->login($pelamar);

        return redirect('/pelamar/dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }
}