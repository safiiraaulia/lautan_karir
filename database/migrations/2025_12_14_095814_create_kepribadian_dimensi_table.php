<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKepribadianDimensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kepribadian_dimensi', function (Blueprint $table) {
            $table->id('id_dimensi');
            $table->string('kode_dimensi', 5); // O, C, E, A, N
            $table->string('nama_dimensi');
            $table->text('deskripsi')->nullable();
            $table->string('model')->default('BIG_FIVE');
            $table->timestamps();
            $table->index('kode_dimensi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kepribadian_dimensi');
    }
}
