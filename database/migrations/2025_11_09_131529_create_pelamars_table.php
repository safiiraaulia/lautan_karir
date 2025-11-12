<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelamarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelamar', function (Blueprint $table) {
            $table->id('id_pelamar'); // Sesuai brief
            $table->string('nama');
            $table->string('username')->unique(); // Sesuai brief
            $table->string('email')->unique();
            $table->string('nomor_whatsapp');
            $table->string('password');
            // $table->rememberToken(); // Opsional untuk "Ingat Saya"
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
        Schema::dropIfExists('pelamars');
    }
}
