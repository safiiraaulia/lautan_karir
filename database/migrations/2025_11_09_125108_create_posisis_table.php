<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('posisi', function (Blueprint $table) {
        $table->string('kode_posisi', 10)->primary();
        $table->string('nama_posisi');
        $table->string('level')->nullable(); // Staff / Supervisor / Manager
        $table->boolean('is_active')->default(true);
        $table->timestamps();
        $table->softDeletes();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posisis');
    }
}
