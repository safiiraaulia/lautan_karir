<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PapikostikScoring extends Model
{
    use HasFactory;

    protected $table = 'papikostik_scoring'; // pastikan sesuai tabel
    protected $primaryKey = 'id_scoring';   // sesuaikan migration
    public $timestamps = false;

    protected $fillable = [
        'soal_id',
        'pilihan',
        'aspek_id',
        'bobot',
    ];
}
