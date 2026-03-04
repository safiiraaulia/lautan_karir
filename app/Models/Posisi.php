<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posisi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posisi';
    protected $primaryKey = 'kode_posisi';
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'kode_posisi',
        'nama_posisi',
        'level',
        'is_active',
    ];

    public function lowongan()
    {
        return $this->hasMany(Lowongan::class, 'posisi_id', 'kode_posisi');
    }

    public function kriteria()
    {
        return $this->belongsToMany(
            Kriteria::class, 
            'kriteria_posisi', 
            'posisi_id', 
            'kriteria_id'    
        )
        ->withPivot('bobot_saw', 'syarat');
    }
}