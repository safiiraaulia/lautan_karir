<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapikostikScoringTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papikostik_scoring', function (Blueprint $table) {
            $table->id('id_scoring');
            $table->unsignedBigInteger('soal_id');
            $table->unsignedBigInteger('aspek_id');
            $table->enum('pilihan', ['A', 'B']); // Sesuai dengan seeder
            $table->integer('bobot')->default(1);
            $table->timestamps();

            $table->foreign('soal_id')->references('id_soal')->on('soal')->onDelete('cascade');
            $table->foreign('aspek_id')->references('id_aspek')->on('papikostik_aspek')->onDelete('cascade');
            $table->index(['soal_id', 'pilihan']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('papikostik_scoring');
    }
}
