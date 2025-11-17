<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Pastikan nama class ini juga benar
class CreateKriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kriteria', function (Blueprint $table) {
            $table->bigIncrements('id_kriteria');
            $table->string('nama_kriteria');

            // --- INI ADALAH KOLOM YANG HILANG ---
            $table->enum('jenis', ['Benefit', 'Cost']);
            $table->float('bobot_saw'); // (Kita sepakat biarkan ini, tipe float)
            // -------------------------------------
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kriteria');
    }
}