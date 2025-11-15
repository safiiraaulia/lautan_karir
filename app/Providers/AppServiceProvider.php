<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Directive untuk cek role
        Blade::if('role', function (...$roles) {
            if (!Auth::guard('web')->check()) {
                return false;
            }
            return in_array(Auth::guard('web')->user()->role, $roles);
        });
    }
}