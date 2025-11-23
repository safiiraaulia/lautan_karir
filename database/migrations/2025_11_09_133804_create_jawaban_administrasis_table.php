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
            $table->id('id_jawaban'); // Primary Key disesuaikan dengan Model
            $table->unsignedBigInteger('lamaran_id');
            $table->unsignedBigInteger('kriteria_id');
            
            // --- PERBAIKAN UTAMA: Ganti kolom teks dengan ID Skala ---
            // $table->text('jawaban_kualitatif'); // HAPUS INI
            $table->unsignedBigInteger('skala_nilai_id'); // GANTI DENGAN INI
            // ---------------------------------------------------------

            $table->foreign('lamaran_id')->references('id_lamaran')->on('lamaran')->onDelete('cascade');
            $table->foreign('kriteria_id')->references('id_kriteria')->on('kriteria')->onDelete('cascade');
            
            // Tambahkan relasi ke tabel skala_nilai agar aman
            $table->foreign('skala_nilai_id')->references('id_skala')->on('skala_nilai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jawaban_administrasi');
    }
}