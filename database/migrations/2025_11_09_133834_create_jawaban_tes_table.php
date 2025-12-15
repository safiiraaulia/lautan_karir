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
        Schema::create('jawaban_tes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lamaran_id');
            $table->unsignedBigInteger('soal_id');
            $table->text('jawaban_teks')->nullable(); // Untuk esai atau pilihan ganda
            $table->string('path_file_upload')->nullable(); // Untuk soal upload

            $table->timestamp('dijawab_pada')->useCurrent(); // Tracking waktu jawab

            $table->foreign('lamaran_id')->references('id_lamaran')->on('lamaran')->onDelete('cascade');
            $table->foreign('soal_id')->references('id_soal')->on('soal');
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
        Schema::dropIfExists('jawaban_tes');
    }
}
