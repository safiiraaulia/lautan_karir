<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelamarPekerjaan extends Model
{
    use HasFactory;
    protected $table = 'pelamar_pekerjaan';

    protected $fillable = [
        'pelamar_id',
        'nama_perusahaan',
        'posisi',
        'tahun_masuk',
        'tahun_keluar'
    ];
}