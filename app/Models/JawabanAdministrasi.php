<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanAdministrasi extends Model
{
    use HasFactory;
    
    protected $table = 'jawaban_administrasi';
    
    // KOREKSI 1: Primary Key
    // Sesuai perintah SQL "CREATE TABLE" sebelumnya, kolom ID bernama 'id'. 
    // Kecuali Anda mengubahnya manual jadi 'id_jawaban', gunakan 'id'.
    protected $primaryKey = 'id'; 

    // KOREKSI 2: Timestamps
    // Tadi kita sudah menjalankan "ADD COLUMN created_at...", 
    // jadi ini harus TRUE agar tanggal tercatat otomatis.
    public $timestamps = true; 

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'lamaran_id',     
        'kriteria_id',
        'skala_nilai_id', 
        'nilai', // KOREKSI 3: Wajib ada agar angka bobot (1-5) tersimpan
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

    // Saya ubah namanya jadi 'skala' (singkat) agar konsisten dengan Controller
    public function skala()
    {
        return $this->belongsTo(SkalaNilai::class, 'skala_nilai_id', 'id_skala');
    }
}