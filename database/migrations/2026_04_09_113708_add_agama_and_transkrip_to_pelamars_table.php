<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pelamar', function (Blueprint $table) {
            $table->string('agama')->nullable()->after('jenis_kelamin');
            $table->string('path_transkrip')->nullable()->after('path_lamaran');
        });
    }

    public function down(): void
    {
        Schema::table('pelamar', function (Blueprint $table) {
            $table->dropColumn(['agama', 'path_transkrip']);
        });
    }
        };