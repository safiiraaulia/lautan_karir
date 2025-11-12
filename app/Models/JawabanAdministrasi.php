<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanAdministrasi extends Model
{
    use HasFactory;
    protected $table = 'jawaban_administrasi';
    public $timestamps = false;

    /**
     * Relasi: Satu Jawaban dimiliki oleh Satu Lamaran
     */
    public function lamaran()
    {
        return $this->belongsTo(Lamaran::class, 'lamaran_id', 'id_lamaran');
    }

    /**
     * Relasi: Satu Jawaban mengacu pada Satu Kriteria
     */
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id', 'id_kriteria');
    }
}