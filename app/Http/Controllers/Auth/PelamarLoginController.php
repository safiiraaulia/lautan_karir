<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelamarLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:pelamar')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.pelamar-login');
    }

    public function login(Request $request)
    {
        // 1. Validasi Input
        $this->validate($request, ['email'    => 'required|email', 'password' => 'required|min:6']);

        // 2. Cek Kredensial (Email & Password Benar?)
        if (Auth::guard('pelamar')->attempt(['email' => $request->email, 'password' => $request->password], 
        $request->get('remember'))) {

            // 3. Ambil data user yang login
            $user = Auth::guard('pelamar')->user();

            // CEK STATUS: is_active
            if ($user->is_active == 0) {
                
                // Jika nonaktif, pelamar otomatis logout
                Auth::guard('pelamar')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Kembali login dengan pesan error
                return back()
                    ->withInput($request->only('email', 'remember'))
                    ->with('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi admin.');
            }

            // Jika is_active = 1, lanjut masuk Dashboard
            return redirect()->intended(route('pelamar.dashboard'));
        }

        return back()->withInput($request->only('email', 'remember'))
                    ->with('error', 'Email atau Password salah.');
    }

    public function logout(Request $request)
    {
        Auth::guard('pelamar')->logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}