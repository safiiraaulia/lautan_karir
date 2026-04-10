<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Lowongan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lowongan';
    protected $primaryKey = 'id_lowongan';

    protected $fillable = [
        'posisi_id',
        'dealer_id',
        'tgl_buka',
        'tgl_tutup',
        'status',
        'deskripsi',
    ];

    protected $casts = [
        'tgl_buka' => 'date',
        'tgl_tutup' => 'date',
        'deleted_at' => 'datetime',
    ];

    // --- TAMBAHAN LOGIKA OTOMATIS ---
    /**
     * Cek apakah tanggal saat ini sudah melewati tanggal tutup.
     */
    public function getIsExpiredAttribute()
    {
        return $this->tgl_tutup && $this->tgl_tutup->isPast();
    }

    public function posisi()
    {
        return $this->belongsTo(Posisi::class, 'posisi_id', 'kode_posisi');
    }

    public function dealer()
    {
        return $this->belongsTo(Dealer::class, 'dealer_id', 'kode_dealer');
    }

    public function lamaran()
    {
        return $this->hasMany(Lamaran::class, 'lowongan_id', 'id_lowongan');
    }
}