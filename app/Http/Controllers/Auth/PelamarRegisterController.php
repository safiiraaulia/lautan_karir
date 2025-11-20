<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PelamarRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:pelamar');
    }

    public function showRegistrationForm()
    {
        return view('auth.pelamar-register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $pelamar = $this->create($request->all());

        // Auto-login setelah register
        Auth::guard('pelamar')->login($pelamar);

        return redirect()->route('pelamar.dashboard')->with('success', 'Registrasi berhasil! Silakan lengkapi profil Anda.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:pelamar'],
            'nomor_whatsapp' => ['required', 'string', 'max:15'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return Pelamar::create([
            'nama' => $data['nama'],
            'username' => strtolower(str_replace(' ', '', $data['nama'])) . mt_rand(100, 999),            'email' => $data['email'],
            'nomor_whatsapp' => $data['nomor_whatsapp'],
            'password' => Hash::make($data['password']),
            'is_active' => true, // Default aktif
        ]);
    }
}