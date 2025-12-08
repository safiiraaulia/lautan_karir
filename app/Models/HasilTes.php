<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilTes extends Model
{
    use HasFactory;

    protected $table = 'hasil_tes';
    protected $primaryKey = 'id_hasil_tes';
    
    // Daftar kolom yang boleh diisi
    protected $fillable = [
        'lamaran_id',
        'jenis_tes_id',
        'detail_nilai',
        'kesimpulan',
    ];

    /**
     * FITUR PENTING:
     * Mengubah kolom database 'detail_nilai' (JSON) menjadi Array PHP secara otomatis.
     * Jadi saat coding, Anda tinggal panggil $hasil->detail_nilai['Leadership']
     */
    protected $casts = [
        'detail_nilai' => 'array',
    ];

    // --- RELASI ---

    /**
     * Relasi: Hasil Tes milik satu Lamaran
     */
    public function lamaran()
    {
        return $this->belongsTo(Lamaran::class, 'lamaran_id', 'id_lamaran');
    }

    /**
     * Relasi: Hasil Tes merujuk pada satu Jenis Tes (Papikostik/Kepribadian/dll)
     */
    public function jenisTes()
    {
        return $this->belongsTo(JenisTes::class, 'jenis_tes_id', 'id_jenis_tes');
    }
}