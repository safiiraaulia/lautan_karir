<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepribadianDimensi extends Model
{
    use HasFactory;

    protected $table = 'kepribadian_dimensi';
    protected $primaryKey = 'id_dimensi';
    
    /**
     * Kolom yang bisa diisi mass assignment
     */
    protected $fillable = [
        'kode_dimensi',
        'nama_dimensi',
        'deskripsi',
        'model'
    ];

    /**
     * Nonaktifkan timestamps jika tidak ada created_at/updated_at
     * (Sesuaikan dengan migration Anda)
     */
    public $timestamps = true; // Ubah jadi false jika migration tidak punya timestamps

    // =========================================
    // RELASI
    // =========================================

    /**
     * Relasi: Satu Dimensi memiliki banyak Scoring Rules
     */
    public function scoringRules()
    {
        return $this->hasMany(KepribadianScoring::class, 'dimensi_id', 'id_dimensi');
    }

    /**
     * Relasi: Dimensi bisa muncul di banyak Soal (via scoring)
     */
    public function soal()
    {
        return $this->belongsToMany(
            Soal::class, 
            'kepribadian_scoring', // tabel pivot
            'dimensi_id', 
            'soal_id'
        );
    }

    // =========================================
    // HELPER METHOD
    // =========================================

    /**
     * Mendapatkan interpretasi berdasarkan skor
     * 
     * Contoh penggunaan:
     * $dimensi = KepribadianDimensi::where('kode_dimensi', 'O')->first();
     * $interpretasi = $dimensi->getInterpretasi(35); // skor 35
     * 
     * @param int $skor
     * @return string
     */
    public function getInterpretasi($skor)
    {
        // Standar Big Five: Skor 1-5 per soal, 10 soal = max 50
        // Interpretasi sederhana (bisa diperluas dengan tabel norma)
        
        if ($skor >= 40) {
            return "Sangat Tinggi pada {$this->nama_dimensi}";
        } elseif ($skor >= 30) {
            return "Tinggi pada {$this->nama_dimensi}";
        } elseif ($skor >= 20) {
            return "Sedang pada {$this->nama_dimensi}";
        } elseif ($skor >= 10) {
            return "Rendah pada {$this->nama_dimensi}";
        } else {
            return "Sangat Rendah pada {$this->nama_dimensi}";
        }
    }

    /**
     * Get dimensi berdasarkan kode (O, C, E, A, N)
     * 
     * @param string $kode
     * @return KepribadianDimensi|null
     */
    public static function findByKode($kode)
    {
        return self::where('kode_dimensi', $kode)->first();
    }
}