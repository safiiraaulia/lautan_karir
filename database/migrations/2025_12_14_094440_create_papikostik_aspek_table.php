<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePapikostikAspekTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * Tabel ini menyimpan 19 aspek kepribadian dari Tes Papikostik
     * Berdasarkan form yang dilampirkan, ada huruf: N, G, A, R, D, C, T, V, L, P, I, F, W, X, S, O, O, Z, K
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('papikostik_aspek', function (Blueprint $table) {
            $table->id('id_aspek');
            $table->string('kode_aspek', 5)->unique(); // N, G, A, R, D, C, T, V, L, P, I, F, W, X, S, O, Z, K
            $table->string('nama_aspek'); // Nama lengkap aspek (Leadership, Need to Control, dll)
            $table->text('deskripsi')->nullable(); // Penjelasan detail aspek
            $table->string('kategori')->nullable(); // 'Work Direction', 'Work Style', 'Social Nature', dll
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
        Schema::dropIfExists('papikostik_aspek');
    }
}