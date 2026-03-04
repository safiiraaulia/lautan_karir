<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpsiJawaban extends Model
{
    use HasFactory;

    protected $table = 'opsi_jawaban';
    protected $primaryKey = 'id_opsi';
    public $timestamps = false;

    protected $fillable = [
        'soal_id',    
        'isi_opsi',    
        'kode_aspek'   
    ];
    
    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id_soal');
    }
}