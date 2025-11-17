<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            // Gunakan id_admin agar konsisten
            $table->id('id_admin'); 
            $table->string('username')->unique();
            $table->string('password');
            
           
            $table->enum('role', ['SUPER_ADMIN', 'HRD']);
            $table->boolean('is_active')->default(true);
            // ===================================
            
            $table->rememberToken();
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
        Schema::dropIfExists('admins');
    }
}