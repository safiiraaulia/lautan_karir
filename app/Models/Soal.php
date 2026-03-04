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

    public function jenisTes()
    {
        return $this->belongsTo(JenisTes::class, 'jenis_tes_id', 'id_jenis_tes');
    }

    public function opsiJawaban()
    {
        return $this->hasMany(OpsiJawaban::class, 'soal_id', 'id_soal');
    }

    public function jawabanTes()
    {
        return $this->hasMany(JawabanTes::class, 'soal_id', 'id_soal');
    }
}