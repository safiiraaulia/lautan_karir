<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkalaNilaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skala_nilai', function (Blueprint $table) {
            $table->bigIncrements('id_skala'); // <-- Sudah benar (auto-increment)

            // === PERUBAHAN DIMULAI DI SINI ===

            // 1. Tambahkan kolom posisi_id (tipe STRING)
            $table->string('posisi_id', 10); 

            $table->unsignedBigInteger('kriteria_id');
            $table->string('deskripsi');
            $table->integer('nilai');

            // 2. Tambahkan Foreign Key untuk posisi_id
            $table->foreign('posisi_id')
                  ->references('kode_posisi') // <-- Referensi ke kode_posisi
                  ->on('posisi') // <-- di tabel posisi
                  ->onDelete('cascade');

            // === BATAS PERUBAHAN ===

            $table->foreign('kriteria_id')
                  ->references('id_kriteria')
                  ->on('kriteria')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skala_nilai');
    }
}