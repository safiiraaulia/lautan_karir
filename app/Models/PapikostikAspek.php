<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PapikostikAspek extends Model
{
    use HasFactory;

    protected $table = 'papikostik_aspek';
    protected $primaryKey = 'id_aspek';

    protected $fillable = [
        'kode_aspek',
        'nama_aspek',
        'deskripsi',
        'kategori'
    ];

    /**
     * Relasi: Satu Aspek memiliki banyak Scoring Rules
     */
    public function scoringRules()
    {
        return $this->hasMany(PapikostikScoring::class, 'aspek_id', 'id_aspek');
    }

    /**
     * Relasi: Satu Aspek memiliki banyak Norma Penilaian
     */
    public function norma()
    {
        return $this->hasMany(PapikostikNorma::class, 'aspek_id', 'id_aspek');
    }

    /**
     * Method untuk mendapatkan interpretasi berdasarkan skor
     */
    public function getInterpretasi($skor)
    {
        return $this->norma()
            ->where('skor_min', '<=', $skor)
            ->where('skor_max', '>=', $skor)
            ->first();
    }
}