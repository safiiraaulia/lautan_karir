<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanTesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::disableForeignKeyConstraints();

    Schema::create('jawaban_tes', function (Blueprint $table) {
        $table->id('id_jawaban');
        $table->unsignedBigInteger('pelamar_id'); 
        $table->unsignedBigInteger('soal_id'); 
        $table->string('most', 5)->nullable();
        $table->string('least', 5)->nullable();
        $table->string('jawaban_papikostik', 5)->nullable();
        $table->timestamps();

        $table->foreign('soal_id')->references('id_soal_kelompok')->on('soal_kelompok')->onDelete('cascade');
        
        $table->foreign('pelamar_id')->references('id')->on('pelamars')->onDelete('cascade');
    });

    Schema::enableForeignKeyConstraints();
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jawaban_tes');
    }
}