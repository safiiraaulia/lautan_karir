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
     * Relasi: Satu Lamaran dimiliki oleh Satu Pelamar
     */
    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class, 'pelamar_id', 'id_pelamar');
    }

    /**
     * Relasi: Satu Lamaran dimiliki oleh Satu Lowongan
     */
    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id', 'id_lowongan');
    }

    /**
     * Relasi: Satu Lamaran memiliki Banyak Jawaban Administrasi
     */
    public function jawabanAdministrasi()
    {
        return $this->hasMany(JawabanAdministrasi::class, 'lamaran_id', 'id_lamaran');
    }

    /**
     * Relasi: Satu Lamaran memiliki Banyak Jawaban Tes
     */
    public function jawabanTes()
    {
        return $this->hasMany(JawabanTes::class, 'lamaran_id', 'id_lamaran');
    }

    /**
     * Relasi: Satu Lamaran memiliki Banyak Progress Tes
     */
    public function progressTes()
    {
        return $this->hasMany(ProgressTes::class, 'lamaran_id', 'id_lamaran');
    }
}