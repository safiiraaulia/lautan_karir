<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalKelompok extends Model
{
    use HasFactory;

    protected $table = 'soal_kelompok';

    protected $primaryKey = 'id_soal_kelompok';

    public $timestamps = true; 

    protected $fillable = [
        'jenis_tes_id',    
        'nomor_kelompok',
        'tipe_soal', 
    ];

    public function jenisTes()
    {
        return $this->belongsTo(JenisTes::class, 'jenis_tes_id', 'id_jenis_tes');
    }

    public function opsiJawaban()
    {
        return $this->hasMany(OpsiJawaban::class, 'soal_id', 'id_soal_kelompok');
    }
}