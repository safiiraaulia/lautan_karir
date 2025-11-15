<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
{
    $guards = empty($guards) ? [null] : $guards;

    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {

            $user = Auth::guard($guard)->user();

            // SUPER ADMIN & HR
            if ($user->role === 'SUPER_ADMIN' || $user->role === 'HR_PUSAT') {
                return redirect('/admin/dashboard');
            }

            // PELAMAR
            if ($user->role === 'pelamar') {
                return redirect('/pelamar/dashboard');
            }

            // Default fallback
            return redirect('/admin/login');
        }
    }

    return $next($request);
}
}
