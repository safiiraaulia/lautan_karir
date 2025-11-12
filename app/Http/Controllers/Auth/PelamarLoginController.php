<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelamarLoginController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // Redirect jika sudah login
        $this->middleware('guest:pelamar')->except('logout');
    }

    /**
     * Tampilkan form login pelamar
     */
    public function showLoginForm()
    {
        return view('auth.pelamar-login');
    }

    /**
     * Proses login pelamar
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string', // Bisa username atau email
            'password' => 'required|string',
        ]);

        // Coba login dengan username atau email
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [$fieldType => $request->username, 'password' => $request->password];

        if (Auth::guard('pelamar')->attempt($credentials, $request->filled('remember'))) {
            // Login berhasil
            $request->session()->regenerate();

            return redirect()->intended('/pelamar/dashboard');
        }

        // Login gagal
        return back()->withErrors([
            'username' => 'Username/Email atau password salah.',
        ])->onlyInput('username');
    }

    /**
     * Logout pelamar
     */
    public function logout(Request $request)
    {
        Auth::guard('pelamar')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/pelamar/login');
    }
}