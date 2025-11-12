<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkalaNilai extends Model
{
    use HasFactory;
    protected $table = 'skala_nilai';
    public $timestamps = false;

    /**
     * Relasi: Satu SkalaNilai dimiliki oleh Satu Kriteria
     */
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id', 'id_kriteria');
    }
}