<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {

            // Jika akses halaman admin tanpa login
            if ($request->is('admin/*')) {
                return route('admin.login');
            }

            // Jika akses halaman pelamar tanpa login
            if ($request->is('pelamar/*')) {
                return route('pelamar.login');
            }

            // Default (kalau ada)
            return route('login');
        }
    }
}
