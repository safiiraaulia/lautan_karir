<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelamar extends Authenticatable
{
    use HasFactory, Notifiable;
    

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
        'password',
        // 'remember_token', // Aktifkan jika Anda menambah 'remember_token' di migrasi
    ];

    protected $casts = [
        'is_active' => 'boolean', // Konversi 'is_active' (0/1) menjadi true/false
        // 'email_verified_at' => 'datetime', // (Opsional) Jika Anda menerapkan verifikasi email
    ];

    // -------------------------------------------------------------------------
    // RELASI ELOQUENT
    // -------------------------------------------------------------------------

    /**
     * Mendapatkan semua lamaran yang dimiliki oleh pelamar ini.
     * Relasi: One-to-Many (Satu Pelamar memiliki Banyak Lamaran)
     */
    public function lamaran()
    {
        // 'Lamaran::class' -> Model tujuan
        // 'pelamar_id' -> Foreign key di tabel 'lamaran'
        // 'id_pelamar' -> Local key (primary key) di tabel 'pelamar'
        return $this->hasMany(Lamaran::class, 'pelamar_id', 'id_pelamar');
    }

    // Relasi ke Tabel Keluarga (Anak)
    public function keluarga()
    {
        return $this->hasMany(PelamarKeluarga::class, 'pelamar_id', 'id_pelamar');
    }

    // Relasi ke Tabel Pendidikan
    public function pendidikan()
    {
        return $this->hasMany(PelamarPendidikan::class, 'pelamar_id', 'id_pelamar');
    }

    // Relasi ke Tabel Pekerjaan
    public function pekerjaan()
    {
        return $this->hasMany(PelamarPekerjaan::class, 'pelamar_id', 'id_pelamar');
    }
}