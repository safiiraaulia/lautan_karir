<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoalKelompokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soal_kelompok', function (Blueprint $table) {
            $table->id('id_soal_kelompok');
            $table->unsignedBigInteger('jenis_tes_id');
            
            // PASTIKAN NAMA KOLOMNYA ADALAH 'nomor_kelompok'
            $table->integer('nomor_kelompok'); 
            
            $table->string('tipe_soal')->default('disc');
            $table->timestamps();

            $table->foreign('jenis_tes_id')->references('id_jenis_tes')->on('jenis_tes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soal_kelompok');
    }
}