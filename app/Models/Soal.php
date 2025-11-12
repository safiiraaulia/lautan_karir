<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;
    protected $table = 'soal';
    protected $primaryKey = 'id_soal';
    public $timestamps = false;

    /**
     * Relasi: Satu Soal dimiliki oleh Satu JenisTes
     */
    public function jenisTes()
    {
        return $this->belongsTo(JenisTes::class, 'jenis_tes_id', 'id_jenis_tes');
    }

    /**
     * Relasi: Satu Soal memiliki Banyak OpsiJawaban (jika Pilihan Ganda)
     */
    public function opsiJawaban()
    {
        return $this->hasMany(OpsiJawaban::class, 'soal_id', 'id_soal');
    }

    /**
     * Relasi: Satu Soal memiliki Banyak JawabanTes dari pelamar
     */
    public function jawabanTes()
    {
        return $this->hasMany(JawabanTes::class, 'soal_id', 'id_soal');
    }
}