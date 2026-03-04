<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckActivePelamar
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah pelamar sedang login dan apakah status akunnya tidak aktif
        if (Auth::guard('pelamar')->check() && !Auth::guard('pelamar')->user()->is_active) {
            
            Auth::guard('pelamar')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Akun Anda telah dinonaktifkan oleh Admin. Silakan hubungi kami untuk informasi lebih lanjut.');
        }

        return $next($request);
    }
}