<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ======================================================
// == FIX 1: Ganti nama class agar sesuai nama file ==
// ======================================================
class CreateKriteriaPosisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kriteria_posisi', function (Blueprint $table) {
            // Ini dari perbaikan kita sebelumnya (sudah benar)
            $table->string('posisi_id', 10); 
            $table->unsignedBigInteger('kriteria_id');

            // ======================================================
            // == FIX 2: Ganti 'integer' menjadi 'float' untuk bobot desimal ==
            // ======================================================
            $table->float('bobot_saw'); 

            // Foreign keys (sudah benar)
            $table->foreign('posisi_id')->references('kode_posisi')->on('posisi')->onDelete('cascade');
            $table->foreign('kriteria_id')->references('id_kriteria')->on('kriteria')->onDelete('cascade');

            $table->primary(['posisi_id', 'kriteria_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kriteria_posisi');
    }
}