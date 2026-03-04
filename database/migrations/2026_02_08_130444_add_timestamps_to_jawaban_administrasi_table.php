<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToJawabanAdministrasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jawaban_administrasi', function (Blueprint $table) {
            // Menambahkan created_at dan updated_at secara otomatis
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('jawaban_administrasi', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}
