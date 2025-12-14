<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posisi extends Model
{
    use HasFactory, SoftDeletes;

    // --- PENGATURAN MODEL UNTUK PRIMARY KEY 'kode_posisi' ---

    protected $table = 'posisi'; // Nama tabel sudah benar

    /**
     * Tentukan Primary Key.
     */
    protected $primaryKey = 'kode_posisi';

    /**
     * Beri tahu Eloquent bahwa Primary Key BUKAN angka (integer).
     */
    public $incrementing = false;

    /**
     * Tentukan tipe data Primary Key (string).
     */
    protected $keyType = 'string';

    /**
     * Tentukan kolom yang boleh diisi oleh form (PENTING!).
     */
    protected $fillable = [
        'kode_posisi',
        'nama_posisi',
        'level',
        'is_active',
    ];

    // --- RELASI-RELASI ---

    /**
     * Relasi: Satu Posisi memiliki banyak Lowongan
     */
    public function lowongan()
    {
        return $this->hasMany(Lowongan::class, 'posisi_id', 'kode_posisi');
    }

    /**
     * Relasi: Satu Posisi membutuhkan banyak Kriteria (Many-to-Many)
     */
    public function kriteria()
    {
        return $this->belongsToMany(
            Kriteria::class, 
            'kriteria_posisi', // Nama tabel pivot
            'posisi_id',       // Foreign key di pivot untuk Posisi
            'kriteria_id'      // Foreign key di pivot untuk Kriteria
        )
        ->withPivot('bobot_saw', 'syarat'); // (Opsional) jika ingin ambil bobotnya
    }
}