<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // Redirect jika sudah login
        $this->middleware('guest:web')->except('logout');
    }

    /**
     * Tampilkan form login admin
     */
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Coba login dengan guard 'web'
        $credentials = $request->only('username', 'password');

        if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
            // Login berhasil
            $request->session()->regenerate();
            
            // Redirect berdasarkan role
            $user = Auth::guard('web')->user();
            
            if ($user->role === 'SUPER_ADMIN' || $user->role === 'HR_PUSAT') {
                return redirect()->intended('/admin/dashboard');
            }
            
            // Jika role tidak dikenal, logout
            Auth::guard('web')->logout();
            return back()->withErrors(['username' => 'Role tidak valid.']);
        }

        // Login gagal
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    /**
     * Logout admin
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}