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

    protected $fillable = [
        'posisi_id',
        'kriteria_id',
        'deskripsi',
        'nilai'
    ];
 
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id', 'id_kriteria');
    }

    public function posisi()
    {
        return $this->belongsTo(Posisi::class, 'posisi_id', 'kode_posisi');
    }
}