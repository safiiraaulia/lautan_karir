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
            $table->id(); // Sesuai brief
            $table->unsignedBigInteger('kriteria_id');
            $table->string('pilihan_kualitatif');
            $table->integer('nilai_kuantitatif');

            $table->foreign('kriteria_id')->references('id_kriteria')->on('kriteria')->onDelete('cascade');
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
        Schema::dropIfExists('skala_nilais');
    }
}
