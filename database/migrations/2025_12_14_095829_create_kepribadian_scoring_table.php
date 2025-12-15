<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKepribadianScoringTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kepribadian_scoring', function (Blueprint $table) {
            $table->id('id_scoring');
            
            $table->unsignedBigInteger('soal_id');
            $table->unsignedBigInteger('dimensi_id');
            
            $table->boolean('is_reverse')->default(false);
            
            $table->integer('bobot')->default(1);
            
            $table->timestamps();

            $table->foreign('soal_id')
                  ->references('id_soal')
                  ->on('soal')
                  ->onDelete('cascade');
                  
            $table->foreign('dimensi_id')
                  ->references('id_dimensi')
                  ->on('kepribadian_dimensi')
                  ->onDelete('cascade');
            
            $table->index('soal_id');
            $table->index('dimensi_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kepribadian_scoring');
    }
}
