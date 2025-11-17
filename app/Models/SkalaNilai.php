<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkalaNilai extends Model
{
    use HasFactory;

    protected $table = 'skala_nilai';
    public $timestamps = false;
    protected $primaryKey = 'id_skala';

    /**
     * ======================================================
     * == PERUBAHAN DI SINI (TAMBAHKAN 'posisi_id') ==
     * ======================================================
     *
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'posisi_id', // <-- DITAMBAHKAN
        'kriteria_id',
        'deskripsi',
        'nilai'
    ];
    // ======================================================


    /**
     * Relasi: Satu SkalaNilai dimiliki oleh Satu Kriteria
     */
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id', 'id_kriteria');
    }

    /**
     * ======================================================
     * == TAMBAHKAN RELASI BARU INI ==
     * ======================================================
     *
     * Relasi: Satu SkalaNilai dimiliki oleh satu Posisi
     */
    public function posisi()
    {
        // 'posisi_id' (FK) -> 'kode_posisi' (PK di tabel posisi)
        return $this->belongsTo(Posisi::class, 'posisi_id', 'kode_posisi');
    }
    // ======================================================
}