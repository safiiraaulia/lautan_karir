<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNilaiSawToLamaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
        {
            Schema::table('lamaran', function (Blueprint $table) { // Pastikan nama tabel 'lamaran'
                // Menyimpan nilai desimal dengan 4 angka di belakang koma
                $table->decimal('nilai_saw', 10, 4)->nullable()->after('status'); 
            });
        }

        public function down()
        {
            Schema::table('lamaran', function (Blueprint $table) {
                $table->dropColumn('nilai_saw');
            });
        }
    }
