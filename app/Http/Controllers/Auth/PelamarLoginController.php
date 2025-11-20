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
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|min:6'
        ]);

        // Cek login menggunakan email, password, DAN is_active=1
        if (Auth::guard('pelamar')->attempt([
            'username' => $request->username, 
            'password' => $request->password,
            'is_active' => 1 // Hanya yang aktif yang bisa login
        ], $request->get('remember'))) {

            return redirect()->intended(route('pelamar.dashboard'));
        }

        return back()->withInput($request->only('email', 'remember'))
                     ->withErrors(['email' => 'Email/Password salah atau akun dinonaktifkan.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('pelamar')->logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}