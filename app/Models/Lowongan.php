<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;
    protected $table = 'lowongan';
    protected $primaryKey = 'id_lowongan';

    /**
     * Relasi: Satu Lowongan dimiliki oleh Satu Posisi
     */
    public function posisi()
    {
        return $this->belongsTo(Posisi::class, 'posisi_id', 'id_posisi');
    }

    /**
     * Relasi: Satu Lowongan dimiliki oleh Satu Dealer
     */
    public function dealer()
    {
        return $this->belongsTo(Dealer::class, 'dealer_id', 'kode_dealer');
    }

    /**
     * Relasi: Satu Lowongan menggunakan Satu PaketTes
     */
    public function paketTes()
    {
        return $this->belongsTo(PaketTes::class, 'paket_tes_id', 'id_paket_tes');
    }

    /**
     * Relasi: Satu Lowongan memiliki Banyak Lamaran
     */
    public function lamaran()
    {
        return $this->hasMany(Lamaran::class, 'lowongan_id', 'id_lowongan');
    }
}