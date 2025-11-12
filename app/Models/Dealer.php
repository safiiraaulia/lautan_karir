<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;
    protected $table = 'dealer'; // Tentukan nama tabel
    protected $primaryKey = 'kode_dealer'; // Tentukan primary key
    public $incrementing = false; // Karena 'kode_dealer' mungkin bukan auto-increment
    protected $keyType = 'string'; // Jika 'kode_dealer' adalah string (varchar)
                                   // Hapus 2 baris ini jika 'kode_dealer' adalah BigInteger

    public $timestamps = false; // Jika tidak ada kolom created_at/updated_at

    protected $fillable = ['kode_dealer', 'nama_dealer', 'kota', 'singkatan'];

    /**
     * Relasi: Satu Dealer bisa memiliki Banyak Lowongan
     */
    public function lowongan()
    {
        return $this->hasMany(Lowongan::class, 'dealer_id', 'kode_dealer');
    }
}