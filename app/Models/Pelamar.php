<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Contracts\Auth\CanResetPassword;

class Pelamar extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, CanResetPasswordTrait;
    
    protected $table = 'pelamar';
    protected $primaryKey = 'id_pelamar';

    protected $fillable = [
        // --- Data Akun ---
        'nama', 'username', 'email', 'nomor_whatsapp', 'password', 'is_active',
        // --- File Upload ---
        'foto', 'path_ktp', 'path_cv', 'path_ijazah', 'path_kk', 'path_lamaran',
        // --- Data Pribadi & Fisik ---
        'kewarganegaraan', 'jenis_kelamin', 'alamat_domisili',
        'tempat_lahir', 'tanggal_lahir', 'status_tempat_tinggal',
        'tinggi_badan', 'berat_badan', 'golongan_darah',
        'no_ktp',
        'status_vaksin',
        // --- Keluarga ---
        'status_pernikahan', 'nama_ibu_kandung', 'nama_suami_istri', 'tanggal_lahir_pasangan',
        // --- Legalitas & Kendaraan ---
        'no_npwp', 'no_bpjs_tk', 'no_bpjs_kes',
        'no_sim_a', 'no_sim_c', 'jenis_kendaraan', 'kepemilikan_kendaraan', 'merk_kendaraan', 'tahun_kendaraan',
    ];

    protected $hidden = [
        'password','remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function lamaran()
    {
        return $this->hasMany(Lamaran::class, 'pelamar_id', 'id_pelamar');
    }

    public function jawabanTes()
    {
        return $this->hasMany(JawabanTes::class, 'pelamar_id', 'id_pelamar');
    }

    public function keluarga()
    {
        return $this->hasMany(PelamarKeluarga::class, 'pelamar_id', 'id_pelamar');
    }

    public function pendidikan()
    {
        return $this->hasMany(PelamarPendidikan::class, 'pelamar_id', 'id_pelamar');
    }

    public function pekerjaan()
    {
        return $this->hasMany(PelamarPekerjaan::class, 'pelamar_id', 'id_pelamar');
    }
}