<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanAdministrasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban_administrasi', function (Blueprint $table) {
            $table->id(); // Sesuai brief
            $table->unsignedBigInteger('lamaran_id');
            $table->unsignedBigInteger('kriteria_id');
            $table->text('jawaban_kualitatif'); // Jawaban mentah dari pelamar

            $table->foreign('lamaran_id')->references('id_lamaran')->on('lamaran')->onDelete('cascade');
            $table->foreign('kriteria_id')->references('id_kriteria')->on('kriteria');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jawaban_administrasis');
    }
}
