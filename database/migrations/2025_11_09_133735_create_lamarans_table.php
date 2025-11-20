<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLamaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lamaran', function (Blueprint $table) {
            $table->id('id_lamaran'); // Sesuai brief
            $table->unsignedBigInteger('pelamar_id');
            $table->unsignedBigInteger('lowongan_id');
            $table->string('status');
            $table->date('tgl_melamar');
            $table->decimal('skor_akhir_saw', 8, 4)->nullable();

            $table->foreign('pelamar_id')->references('id_pelamar')->on('pelamar');
            $table->foreign('lowongan_id')->references('id_lowongan')->on('lowongan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lamarans');
    }
}
