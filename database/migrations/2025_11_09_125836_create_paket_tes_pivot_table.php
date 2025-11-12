<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketTesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_tes_pivot', function (Blueprint $table) {
            $table->unsignedBigInteger('paket_tes_id');
            $table->unsignedBigInteger('jenis_tes_id');
            $table->integer('urutan');

            $table->foreign('paket_tes_id')->references('id_paket_tes')->on('paket_tes')->onDelete('cascade');
            $table->foreign('jenis_tes_id')->references('id_jenis_tes')->on('jenis_tes')->onDelete('cascade');

            $table->primary(['paket_tes_id', 'jenis_tes_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paket_tes_pivot');
    }
}
