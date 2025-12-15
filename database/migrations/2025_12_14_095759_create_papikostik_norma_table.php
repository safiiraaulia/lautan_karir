<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapikostikNormaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('papikostik_norma', function (Blueprint $table) {
            $table->id('id_norma');
            $table->unsignedBigInteger('aspek_id');
            $table->integer('skor_min');
            $table->integer('skor_max');
            $table->string('kategori'); // Rendah, Sedang, Tinggi, Sangat Tinggi
            $table->text('interpretasi'); // Deskripsi hasil
            $table->timestamps();

            $table->foreign('aspek_id')->references('id_aspek')->on('papikostik_aspek')->onDelete('cascade');
            $table->index(['aspek_id', 'skor_min', 'skor_max']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('papikostik_norma');
    }
}
