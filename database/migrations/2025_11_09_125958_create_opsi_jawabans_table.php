<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpsiJawabansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opsi_jawaban', function (Blueprint $table) {
            $table->id('id_opsi'); // Sesuai brief
            $table->unsignedBigInteger('soal_id');
            $table->text('isi_opsi');
            // $table->boolean('is_correct')->default(false); // Opsional jika ada kunci jawaban

            $table->foreign('soal_id')->references('id_soal')->on('soal')->onDelete('cascade');
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
        Schema::dropIfExists('opsi_jawabans');
    }
}
