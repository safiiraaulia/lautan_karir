<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUploadsToPelamarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('pelamar', function (Blueprint $table) {
        $table->string('foto')->nullable()->after('email');
        $table->string('path_ktp')->nullable()->after('foto');
        $table->string('path_cv')->nullable()->after('path_ktp');
        $table->string('path_ijazah')->nullable()->after('path_cv');
        $table->string('path_kk')->nullable()->after('path_ijazah');
        $table->string('path_lamaran')->nullable()->after('path_kk');
    });
}

public function down()
{
    // UBAH MENJADI 'pelamar' (singular)
    Schema::table('pelamar', function (Blueprint $table) { 
        $table->dropColumn(['foto', 'path_ktp', 'path_cv', 'path_ijazah', 'path_kk', 'path_lamaran']);
    });
}
}
