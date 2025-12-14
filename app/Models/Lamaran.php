<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;

    protected $table = 'lamaran';
    
    // Pastikan ini sesuai dengan database (id_lamaran)
    protected $primaryKey = 'id_lamaran'; 

    protected $fillable = [
        'pelamar_id',  
        'lowongan_id',
        'tgl_melamar',
        'status',
        // 'nilai_saw', // Kolom ini opsional, aktifkan jika Anda sudah membuat kolom 'nilai_saw' di tabel lamaran
        'is_read',
    ];

    protected $casts = [
        'tgl_melamar' => 'date',
        'is_read' => 'boolean',
    ];

    // --- RELASI ---

    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class, 'pelamar_id', 'id_pelamar');
    }

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id', 'id_lowongan');
    }

    /**
     * PERBAIKAN: Ubah nama fungsi dari 'jawabanAdministrasi' menjadi 'jawaban'
     * Agar sesuai dengan pemanggilan di SeleksiController ($lamaran->jawaban)
     */
    public function jawaban()
    {
        // Pastikan Model JawabanAdministrasi sudah dibuat
        return $this->hasMany(JawabanAdministrasi::class, 'lamaran_id', 'id_lamaran');
    }

    public function hasilTes()
    {
        return $this->hasMany(HasilTes::class, 'lamaran_id', 'id_lamaran');
    }
}