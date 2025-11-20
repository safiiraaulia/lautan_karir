<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelamarKeluarga extends Model
{
    use HasFactory;
    protected $table = 'pelamar_keluarga';
    
    protected $fillable = [
        'pelamar_id',
        'nama',
        'tanggal_lahir',
        'keterangan' // Anak ke-1, ke-2, dll
    ];
}