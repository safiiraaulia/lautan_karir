<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanTes extends Model
{
    use HasFactory;
    protected $table = 'jawaban_tes';
    public $timestamps = false;

    /**
     * Relasi: Satu Jawaban dimiliki oleh Satu Lamaran
     */
    public function lamaran()
    {
        return $this->belongsTo(Lamaran::class, 'lamaran_id', 'id_lamaran');
    }

    /**
     * Relasi: Satu Jawaban mengacu pada Satu Soal
     */
    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id_soal');
    }
}