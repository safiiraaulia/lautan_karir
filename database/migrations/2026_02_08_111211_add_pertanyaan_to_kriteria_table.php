<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPertanyaanToKriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kriteria', function (Blueprint $table) {
            // Menambahkan kolom pertanyaan setelah kolom nama_kriteria
            $table->string('pertanyaan')->after('nama_kriteria')->nullable();
        });
    }

    public function down()
    {
        Schema::table('kriteria', function (Blueprint $table) {
            $table->dropColumn('pertanyaan');
        });
    }
}
