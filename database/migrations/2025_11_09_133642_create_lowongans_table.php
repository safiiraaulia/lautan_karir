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

        // --- DEFINISI KOLOM ---

        // 1. DARI ERROR POSISI (Harus string)
        $table->string('posisi_id', 10); 

        // 2. DARI ERROR DEALER (Harus unsignedBigInteger)
        $table->string('dealer_id'); 

        // 3. DARI ERROR PAKET TES (Harus unsignedBigInteger)
        $table->unsignedBigInteger('paket_tes_id');

        // Kolom Anda lainnya (pastikan ini ada)
        $table->date('tgl_buka');
        $table->date('tgl_tutup');
        $table->enum('status', ['Buka', 'Tutup']);
        $table->text('deskripsi')->nullable();

        $table->timestamps();
        $table->softDeletes(); // Sebaiknya ditambahkan

        // --- DEFINISI FOREIGN KEY (PERBAIKAN TOTAL) ---

        // 1. FIX UNTUK POSISI
        $table->foreign('posisi_id')->references('kode_posisi')->on('posisi'); 

        // 2. FIX UNTUK DEALER
        $table->foreign('dealer_id')->references('kode_dealer')->on('dealer'); 

        // 3. FIX UNTUK PAKET TES
        $table->foreign('paket_tes_id')->references('id_paket_tes')->on('paket_tes');
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