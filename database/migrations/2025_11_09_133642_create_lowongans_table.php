<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLowongansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lowongan', function (Blueprint $table) {
            $table->id('id_lowongan');
            $table->unsignedBigInteger('posisi_id');
            
            // --------------------------------------------------------
            $table->unsignedBigInteger('dealer_id');
            // --------------------------------------------------------

            $table->unsignedBigInteger('paket_tes_id');
            $table->string('status_publikasi');
            
            // Foreign keys
            $table->foreign('posisi_id')->references('id_posisi')->on('posisi');
            $table->foreign('dealer_id')->references('kode_dealer')->on('dealer'); // Sekarang akan cocok
            $table->foreign('paket_tes_id')->references('id_paket_tes')->on('paket_tes');
            
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
        Schema::dropIfExists('lowongan');
    }
}