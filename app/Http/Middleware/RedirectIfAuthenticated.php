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
                
                // JIKA YANG LOGIN ADALAH ADMIN
                if ($guard === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                // JIKA YANG LOGIN ADALAH PELAMAR
                if ($guard === 'pelamar') {
                    return redirect()->route('pelamar.dashboard');
                }
                
                // DEFAULT (Jaga-jaga)
                return redirect('/');
            }
        }

        return $next($request);
    }
}
