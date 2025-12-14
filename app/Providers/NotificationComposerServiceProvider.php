<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Lamaran; // Import model lamaran

class NotificationComposerServiceProvider extends ServiceProvider
{
    // ... (fungsi register tidak diubah)

    public function boot()
    {
        // 1. Targetkan layout utama (public)
        View::composer('layouts.public', function ($view) {
            $unreadCount = 0;

            // 2. Hanya jalankan query jika pelamar login
            if (Auth::guard('pelamar')->check()) {
                $pelamarId = Auth::guard('pelamar')->user()->id_pelamar;

                $unreadCount = Lamaran::where('pelamar_id', $pelamarId)
                                       ->where('is_read', false)
                                       
                                       // Jangan hitung Pending/Sedang Diproses sebagai notifikasi baru
                                       ->whereNotIn('status', ['Pending', 'Sedang Diproses'])
                                       ->count();
            }

            // 3. Kirim data ke view dengan nama variabel: $unreadNotificationCount
            $view->with('unreadNotificationCount', $unreadCount);
        });
    }
}