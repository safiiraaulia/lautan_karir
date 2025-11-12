<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedBigInteger('posisi_id');
            $table->unsignedBigInteger('kriteria_id');
            $table->integer('bobot_saw');

            // Foreign Keys
            $table->foreign('posisi_id')->references('id_posisi')->on('posisi')->onDelete('cascade');
            $table->foreign('kriteria_id')->references('id_kriteria')->on('kriteria')->onDelete('cascade');

            // Primary key gabungan
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
