<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soal', function (Blueprint $table) {
            $table->id('id_soal'); // Sesuai brief
            $table->unsignedBigInteger('jenis_tes_id');
            $table->text('isi_soal');
            $table->string('tipe_soal'); // misal: 'pilihan_ganda', 'esay', 'upload'

            $table->foreign('jenis_tes_id')->references('id_jenis_tes')->on('jenis_tes')->onDelete('cascade');
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
        Schema::dropIfExists('soals');
    }
}
