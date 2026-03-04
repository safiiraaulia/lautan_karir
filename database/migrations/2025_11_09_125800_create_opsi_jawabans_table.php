<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpsiJawabansTable extends Migration
{
    public function up()
    {
        Schema::create('opsi_jawaban', function (Blueprint $table) {
            $table->id('id_opsi_jawaban'); // Menggunakan nama ID yang lebih standar
            
            // Kolom ini akan menampung ID dari tabel soal_kelompok
            $table->unsignedBigInteger('soal_id'); 
            
            $table->text('isi_opsi'); 
            
            // Label DISC (D, I, S, atau C)
            $table->string('kode_aspek', 2); 

            $table->foreign('soal_id')
                  ->references('id_soal_kelompok')
                  ->on('soal_kelompok')
                  ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('opsi_jawaban');
    }
}