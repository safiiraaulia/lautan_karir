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
        // 1. Ubah validasi dari 'username' menjadi 'email'
        $this->validate($request, [
            'email'   => 'required|email', // Wajib format email
            'password' => 'required|min:6'
        ]);

        // 2. Ubah kredensial yang dicek
        if (Auth::guard('pelamar')->attempt([
            'email' => $request->email, // Cek kolom email
            'password' => $request->password
        ], $request->get('remember'))) {

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