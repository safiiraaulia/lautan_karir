<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressTes extends Model
{
    use HasFactory;
    protected $table = 'progress_tes';
    
    /**
     * Relasi: Satu Progress dimiliki oleh Satu Lamaran
     */
    public function lamaran()
    {
        return $this->belongsTo(Lamaran::class, 'lamaran_id', 'id_lamaran');
    }

    /**
     * Relasi: Satu Progress mengacu pada Satu JenisTes
     */
    public function jenisTes()
    {
        return $this->belongsTo(JenisTes::class, 'jenis_tes_id', 'id_jenis_tes');
    }
}