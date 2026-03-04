<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNilaiToJawabanAdministrasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up() {
        Schema::table('jawaban_administrasi', function (Blueprint $table) {
            $table->integer('nilai')->after('skala_nilai_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jawaban_administrasi', function (Blueprint $table) {
            //
        });
    }
}
