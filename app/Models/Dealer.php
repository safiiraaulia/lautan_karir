<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dealer extends Model
{
        use SoftDeletes;

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
}
