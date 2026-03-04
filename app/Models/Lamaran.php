<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;

    protected $table = 'lamaran';
    
    protected $primaryKey = 'id_lamaran'; 

    protected $fillable = [
        'pelamar_id', 'lowongan_id', 'tgl_melamar', 'status', 'skor_akhir_saw', 'is_read',
    ];

    protected $casts = [
        'tgl_melamar' => 'date',
        'is_read' => 'boolean',
    ];

    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class, 'pelamar_id', 'id_pelamar');
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id', 'id_lowongan');
    }

    public function jawaban()
    {
        return $this->hasMany(JawabanAdministrasi::class, 'lamaran_id', 'id_lamaran');
    }

    public function hasilTes()
    {
        return $this->hasMany(HasilTes::class, 'lamaran_id', 'id_lamaran');
    }
}