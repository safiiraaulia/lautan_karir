<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash; // Tambahan untuk enkripsi password baru

class ForgotPasswordController extends Controller
{
    /**
     * Menampilkan formulir permintaan link reset password.
     */
    public function showLinkRequestForm()
    {
        return view('pelamar.auth.forgot-password');
    }

    /**
     * Mengirimkan link reset password ke email pelamar.
     */
    public function sendResetLinkEmail(Request $request)
    {
        // 1. Validasi input email
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.'
        ]);

        // 2. Kirim link reset melalui broker 'pelamars'
        $status = Password::broker('pelamars')->sendResetLink(
            $request->only('email')
        );

        // 3. Respon berdasarkan hasil pengiriman
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => 'Link reset password telah dikirim ke email Anda!'])
            : back()->withErrors(['email' => 'Email tidak ditemukan di sistem Lautan Karir.']);
    }

    /**
     * Menampilkan formulir untuk mengatur ulang password (setelah klik link email).
     */
    public function showResetForm(Request $request, $token)
    {
        return view('pelamar.auth.reset-password')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Memproses pembaruan password baru ke database.
     */
    public function resetPassword(Request $request)
    {
        // 1. Validasi input password baru
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus 8 karakter.'
        ]);

        // 2. Jalankan proses reset menggunakan broker 'pelamars'
        $status = Password::broker('pelamars')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Simpan password baru dengan enkripsi Hash
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        // 3. Respon berdasarkan hasil reset
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password Anda berhasil diperbarui! Silakan masuk.')
            : back()->withErrors(['email' => [__($status)]]);
    }
}