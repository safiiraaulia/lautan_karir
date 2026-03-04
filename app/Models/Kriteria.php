<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kriteria extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kriteria';
    protected $primaryKey = 'id_kriteria';
    public $timestamps = false; 

    protected $fillable = [
        'nama_kriteria',
        'pertanyaan',
        'jenis',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function posisi()
    {
        return $this->belongsToMany(
            Posisi::class, 
            'kriteria_posisi', 
            'kriteria_id', 
            'posisi_id'
        )->withPivot('bobot_saw', 'syarat');
    }

    public function skalaNilai()
    {
        return $this->hasMany(SkalaNilai::class, 'kriteria_id', 'id_kriteria');
    }
}