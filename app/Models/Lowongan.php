<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- Jangan lupa

class Lowongan extends Model
{
    use HasFactory, SoftDeletes; // <-- Tambahkan SoftDeletes

    protected $table = 'lowongan';
    protected $primaryKey = 'id_lowongan';

    /**
     * Tentukan kolom yang boleh diisi oleh form.
     * Sesuai migrasi Anda.
     */
    protected $fillable = [
        'posisi_id',
        'dealer_id',
        'paket_tes_id',
        'tgl_buka',
        'tgl_tutup',
        'status',
        'deskripsi',
    ];

    /**
     * Tentukan tipe data asli (casting) untuk kolom tanggal.
     */
    protected $casts = [
        'tgl_buka' => 'date',
        'tgl_tutup' => 'date',
    ];

    // --- RELASI-RELASI ---

    /**
     * Relasi: Satu Lowongan dimiliki oleh satu Posisi
     */
    public function posisi()
    {
        // 'posisi_id' -> foreign key di lowongan
        // 'kode_posisi' -> primary key di posisi
        return $this->belongsTo(Posisi::class, 'posisi_id', 'kode_posisi');
    }

    /**
     * Relasi: Satu Lowongan dimiliki oleh satu Dealer
     */
    public function dealer()
    {
        // 'dealer_id' -> foreign key di lowongan
        // 'kode_dealer' -> primary key di dealer
        return $this->belongsTo(Dealer::class, 'dealer_id', 'kode_dealer');
    }

    /**
     * Relasi: Satu Lowongan memiliki satu Paket Tes
     */
    public function paketTes()
    {
        // 'paket_tes_id' -> foreign key di lowongan
        // 'id_paket_tes' -> primary key di paket_tes
        return $this->belongsTo(PaketTes::class, 'paket_tes_id', 'id_paket_tes');
    }

    /**
     * Relasi: Satu Lowongan bisa memiliki banyak Lamaran
     */
    public function lamaran()
    {
        return $this->hasMany(Lamaran::class, 'lowongan_id', 'id_lowongan');
    }
}