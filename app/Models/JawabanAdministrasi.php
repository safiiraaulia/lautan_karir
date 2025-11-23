<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanAdministrasi extends Model
{
    use HasFactory;
    
    protected $table = 'jawaban_administrasi';
    protected $primaryKey = 'id_jawaban';
    public $timestamps = false; // Tabel ini tidak butuh created_at/updated_at

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'lamaran_id',      // <-- Ini yang menyebabkan error Anda
        'kriteria_id',
        'skala_nilai_id', 
    ];

    // --- RELASI ---

    public function lamaran()
    {
        return $this->belongsTo(Lamaran::class, 'lamaran_id', 'id_lamaran');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id', 'id_kriteria');
    }

    public function skalaNilai()
    {
        return $this->belongsTo(SkalaNilai::class, 'skala_nilai_id', 'id_skala');
    }
}