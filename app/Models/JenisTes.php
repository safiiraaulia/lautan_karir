<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTes extends Model
{
    use HasFactory;
    protected $table = 'jenis_tes';
    protected $primaryKey = 'id_jenis_tes';
    public $timestamps = false;

    /**
     * Relasi: Satu JenisTes bisa ada di Banyak PaketTes (via tabel pivot)
     */
    public function paketTes()
    {
        return $this->belongsToMany(PaketTes::class, 'paket_tes_pivot', 'jenis_tes_id', 'paket_tes_id');
    }

    /**
     * Relasi: Satu JenisTes memiliki Banyak Soal
     */
    public function soal()
    {
        return $this->hasMany(Soal::class, 'jenis_tes_id', 'id_jenis_tes');
    }

    /**
     * Relasi: Satu JenisTes memiliki Banyak Progress Tes
     */
    public function progressTes()
    {
        return $this->hasMany(ProgressTes::class, 'jenis_tes_id', 'id_jenis_tes');
    }
}