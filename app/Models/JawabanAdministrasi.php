<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanAdministrasi extends Model
{
    use HasFactory;
    
    protected $table = 'jawaban_administrasi';
    
    protected $primaryKey = 'id_jawaban'; 

    public $timestamps = true; 

    protected $fillable = [
        'lamaran_id',     
        'kriteria_id',
        'skala_nilai_id', 
        'nilai',
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

    public function skala()
    {
        return $this->belongsTo(SkalaNilai::class, 'skala_nilai_id', 'id_skala');
    }
}