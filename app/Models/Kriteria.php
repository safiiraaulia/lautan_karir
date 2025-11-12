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
     * Relasi: Satu Kriteria bisa ada di Banyak Posisi (via tabel pivot)
     */
    public function posisi()
    {
        return $this->belongsToMany(Posisi::class, 'kriteria_posisi', 'kriteria_id', 'posisi_id');
    }

    /**
     * Relasi: Satu Kriteria memiliki Banyak SkalaNilai (opsi)
     */
    public function skalaNilai()
    {
        return $this->hasMany(SkalaNilai::class, 'kriteria_id', 'id_kriteria');
    }

    /**
     * Relasi: Satu Kriteria memiliki Banyak Jawaban Administrasi
     */
    public function jawabanAdministrasi()
    {
        return $this->hasMany(JawabanAdministrasi::class, 'kriteria_id', 'id_kriteria');
    }
}