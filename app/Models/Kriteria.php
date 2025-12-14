<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $table = 'kriteria';
    protected $primaryKey = 'id_kriteria';
    public $timestamps = false;

    /**
     * ======================================================
     * == TAMBAHKAN INI UNTUK MEMPERBAIKI ERROR ==
     * ======================================================
     *
     * Kolom yang boleh diisi secara massal.
     * (Sesuai migrasi ...create_kriterias_table.php)
     */
    protected $fillable = [
        'nama_kriteria',
        'jenis',
        'pertanyaan',
    ];
    // ======================================================


    /**
     * Relasi: Kriteria bisa ada di banyak Posisi
     */
    public function posisi()
    {
        return $this->belongsToMany(
            Posisi::class, 
            'kriteria_posisi', 
            'kriteria_id', 
            'posisi_id'
        );
    }

    /**
     * Relasi: Kriteria punya banyak Skala Nilai
     */
    public function skalaNilai()
    {
        return $this->hasMany(SkalaNilai::class, 'kriteria_id', 'id_kriteria');
    }
}