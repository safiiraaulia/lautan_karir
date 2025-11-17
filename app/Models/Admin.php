<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Tentukan guard yang digunakan untuk model ini.
     */
    protected $guard = 'admin';

    /**
     * Tentukan tabel database yang terkait dengan model ini.
     * HARUS 'admins' (plural), BUKAN 'users' atau 'admin'.
     */
    protected $table = 'admins';

    /**
     * Tentukan primary key.
     */
    protected $primaryKey = 'id_admin'; // Sesuai migrasi Anda

    /**
     * Tentukan atribut yang dapat diisi secara massal.
     * (Saya tambahkan 'email' di sini agar seeder berjalan)
     */
    protected $fillable = [
        'username',
        'password',
        'role',
        'is_active',
    ];

    /**
     * Tentukan atribut yang harus disembunyikan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}