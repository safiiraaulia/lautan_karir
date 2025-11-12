<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PelamarAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Cek apakah user login via guard 'pelamar'
        if (!Auth::guard('pelamar')->check()) {
            // Jika belum login, redirect ke halaman login pelamar
            return redirect()->route('pelamar.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}