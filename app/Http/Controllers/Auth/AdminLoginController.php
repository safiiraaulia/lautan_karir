<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
            'is_active' => true, 
        ];

        // ✅ Login pakai guard ADMIN, bukan WEB
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {

            $request->session()->regenerate();

            $user = Auth::guard('admin')->user();

            // ✅ Hanya SUPER_ADMIN & HRD
            if (in_array($user->role, ['SUPER_ADMIN', 'HRD'])) {
                return redirect()->intended('/admin/dashboard');
            }

            Auth::guard('admin')->logout();
            return back()->withErrors(['username' => 'Role tidak valid.']);
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
