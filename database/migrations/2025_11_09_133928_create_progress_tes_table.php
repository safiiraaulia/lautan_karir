<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgressTesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress_tes', function (Blueprint $table) {
            $table->id(); // Sesuai brief
            $table->unsignedBigInteger('lamaran_id');
            $table->unsignedBigInteger('jenis_tes_id');
            $table->enum('status', ['selesai', 'sedang_dikerjakan']); // Sesuai brief

            $table->foreign('lamaran_id')->references('id_lamaran')->on('lamaran')->onDelete('cascade');
            $table->foreign('jenis_tes_id')->references('id_jenis_tes')->on('jenis_tes');
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
        Schema::dropIfExists('progress_tes');
    }
}
