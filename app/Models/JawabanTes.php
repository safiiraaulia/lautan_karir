<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanTes extends Model
{
    use HasFactory;

    protected $table = 'jawaban_tes';
    
    protected $primaryKey = 'id_jawaban';

    public $timestamps = true;

    protected $fillable = [
        'pelamar_id',
        'soal_id',
        'most',    // DISC Most
        'least', // DISC Least
        'jawaban_papikostik',   // PAPI A/B
    ];

    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class, 'pelamar_id', 'id');
    }

    public function soal()
    {
        return $this->belongsTo(SoalKelompok::class, 'soal_id', 'id_soal_kelompok');
    }
}