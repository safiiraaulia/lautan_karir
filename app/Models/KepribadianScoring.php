<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepribadianScoring extends Model
{
    use HasFactory;

    protected $table = 'kepribadian_scoring';
    protected $primaryKey = 'id_scoring';

    protected $fillable = [
        'soal_id',
        'dimensi_id',
        'is_reverse',
        'bobot'
    ];

    protected $casts = [
        'is_reverse' => 'boolean'
    ];

    /**
     * Relasi: Satu Scoring Rule milik satu Soal
     */
    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id_soal');
    }

    /**
     * Relasi: Satu Scoring Rule milik satu Dimensi
     */
    public function dimensi()
    {
        return $this->belongsTo(KepribadianDimensi::class, 'dimensi_id', 'id_dimensi');
    }

    /**
     * Method untuk menghitung skor (dengan reverse jika perlu)
     */
    public function calculateScore($rawScore)
    {
        if ($this->is_reverse) {
            // Reverse scoring: 5→1, 4→2, 3→3, 2→4, 1→5
            return (6 - $rawScore) * $this->bobot;
        }
        
        return $rawScore * $this->bobot;
    }
}