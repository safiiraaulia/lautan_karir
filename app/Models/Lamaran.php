<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;
    protected $table = 'lamaran';
    protected $primaryKey = 'id_lamaran';

    /**
     * Kolom yang boleh diisi secara massal (create/update).
     * Tambahkan semua kolom tabel di sini.
     */
    protected $fillable = [
        'pelamar_id',  
        'lowongan_id',
        'tgl_melamar',
        'status',
        'nilai_saw',
    ];

    protected $casts = [
        'tgl_melamar' => 'date',
    ];

    // --- RELASI ---

    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class, 'pelamar_id', 'id_pelamar');
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id', 'id_lowongan');
    }

    public function jawabanAdministrasi()
    {
        return $this->hasMany(JawabanAdministrasi::class, 'lamaran_id', 'id_lamaran');
    }

    public function hasilTes()
    {
        return $this->hasMany(HasilTes::class, 'lamaran_id', 'id_lamaran');
    }
}