<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilTesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_tes', function (Blueprint $table) {
            $table->id('id_hasil_tes'); // Primary Key
            
            // Foreign Keys (penghubung)
            $table->unsignedBigInteger('lamaran_id');
            $table->unsignedBigInteger('jenis_tes_id');
            
            
            $table->json('detail_nilai')->nullable(); 
            
            $table->string('kesimpulan')->nullable(); 
            
            $table->timestamps();

            $table->foreign('lamaran_id')
                  ->references('id_lamaran')->on('lamaran') 
                  ->onDelete('cascade');
                  
            $table->foreign('jenis_tes_id')
                  ->references('id_jenis_tes')->on('jenis_tes') 
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hasil_tes');
    }
}