<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketTes extends Model
{
    use HasFactory;
    protected $table = 'paket_tes';
    protected $primaryKey = 'id_paket_tes';
    public $timestamps = false;

    /**
     * Relasi: Satu PaketTes memiliki Banyak JenisTes (via tabel pivot)
     */
    public function jenisTes()
    {
        return $this->belongsToMany(JenisTes::class, 'paket_tes_pivot', 'paket_tes_id', 'jenis_tes_id')
                    ->withPivot('urutan') // Ambil kolom 'urutan'
                    ->orderBy('paket_tes_pivot.urutan', 'asc'); // Langsung urutkan
    }

    /**
     * Relasi: Satu PaketTes bisa dipakai Banyak Lowongan
     */
    public function lowongan()
    {
        return $this->hasMany(Lowongan::class, 'paket_tes_id', 'id_paket_tes');
    }
}