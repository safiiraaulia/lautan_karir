<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dealer extends Model
{
        use HasFactory, SoftDeletes;

    protected $table = 'dealer';
    protected $primaryKey = 'kode_dealer';
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = [
        'kode_dealer',
        'nama_dealer',
        'kota',
        'singkatan',
        'is_active'
    ];

    public function lowongan()
    {
        return $this->hasMany(Lowongan::class, 'dealer_id', 'kode_dealer');
    }
}
