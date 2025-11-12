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
        'nama',
        'username',
        'email',
        'nomor_whatsapp',
        'password',
        'is_active', // Ditambahkan dari migrasi terakhir
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
}