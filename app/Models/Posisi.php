<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posisi extends Model
{
    use HasFactory;
    protected $table = 'posisi';
    protected $primaryKey = 'id_posisi';
    public $timestamps = false;

    /**
     * Relasi: Satu Posisi bisa memiliki Banyak Lowongan
     */
    public function lowongan()
    {
        return $this->hasMany(Lowongan::class, 'posisi_id', 'id_posisi');
    }

    /**
     * Relasi: Satu Posisi memiliki Banyak Kriteria (via tabel pivot)
     */
    public function kriteria()
    {
        return $this->belongsToMany(Kriteria::class, 'kriteria_posisi', 'posisi_id', 'kriteria_id')
                    ->withPivot('bobot_saw'); // Penting untuk mengambil bobot
    }
}