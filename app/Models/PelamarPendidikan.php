<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelamarPendidikan extends Model
{
    use HasFactory;
    protected $table = 'pelamar_pendidikan';

    protected $fillable = [
        'pelamar_id',
        'jenjang', // SMA, S1, dll
        'jurusan',
        'nama_sekolah',
        'kota',
        'tahun_lulus',
        'nilai_akhir' // IPK / Nem
    ];
}