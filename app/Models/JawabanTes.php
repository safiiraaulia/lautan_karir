<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanTes extends Model
{
    use HasFactory;
    protected $table = 'jawaban_tes';
    public $timestamps = false;

    protected $fillable = [
        'lamaran_id',
        'soal_id',
        'jawaban_teks',
        'path_file_upload',
        'dijawab_pada'
    ];
    
    public function lamaran()
    {
        return $this->belongsTo(Lamaran::class, 'lamaran_id', 'id_lamaran');
    }

    /**
     * Relasi: Satu Jawaban mengacu pada Satu Soal
     */
    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id_soal');
    }
}