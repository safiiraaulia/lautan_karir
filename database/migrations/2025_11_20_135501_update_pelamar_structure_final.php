<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePelamarStructureFinal extends Migration
{
    public function up()
    {
        // 1. UPDATE TABEL PELAMAR (Data Single)
        Schema::table('pelamar', function (Blueprint $table) {
            $table->string('no_ktp', 16)->nullable()->after('nama');
            // --- BAGIAN 1: DATA PRIBADI & FISIK ---
            //$table->string('penempatan')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->text('alamat_domisili')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('status_tempat_tinggal')->nullable();
            $table->integer('tinggi_badan')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->string('golongan_darah')->nullable();

            // --- BAGIAN 2: SUSUNAN KELUARGA (Inti) ---
            $table->string('status_pernikahan')->nullable();
            $table->string('nama_ibu_kandung')->nullable();
            $table->string('nama_suami_istri')->nullable();
            $table->date('tanggal_lahir_pasangan')->nullable();
            
            // --- BAGIAN 3: DATA LEGALITAS ---
            $table->string('no_npwp')->nullable();
            $table->string('no_bpjs_tk')->nullable();
            $table->string('no_bpjs_kes')->nullable();

            // --- BAGIAN 4: SIM & KENDARAAN ---
            $table->string('no_sim_a')->nullable();
            $table->string('no_sim_c')->nullable();
            $table->string('jenis_kendaraan')->nullable();
            $table->string('kepemilikan_kendaraan')->nullable();
            $table->string('merk_kendaraan')->nullable();
            $table->string('tahun_kendaraan')->nullable();

            // --- BAGIAN 7: STATUS VAKSIN ---
            $table->string('status_vaksin')->nullable();
        });

        // 2. TABEL ANAK (Bagian 2 - Lanjutan)
        Schema::create('pelamar_keluarga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelamar_id');
            $table->string('nama');
            $table->date('tanggal_lahir')->nullable();
            $table->string('keterangan')->nullable(); // Anak ke-1, ke-2
            $table->timestamps();

            $table->foreign('pelamar_id')->references('id_pelamar')->on('pelamar')->onDelete('cascade');
        });

        // 3. TABEL PENDIDIKAN (Bagian 5)
        Schema::create('pelamar_pendidikan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelamar_id');
            $table->string('jenjang'); // SMA/SMK/D3/S1
            $table->string('jurusan')->nullable();
            $table->string('nama_sekolah')->nullable();
            $table->string('kota')->nullable();
            $table->string('tahun_lulus')->nullable();
            $table->string('nilai_akhir')->nullable();
            $table->timestamps();

            $table->foreign('pelamar_id')->references('id_pelamar')->on('pelamar')->onDelete('cascade');
        });

        // 4. TABEL PENGALAMAN KERJA (Bagian 6)
        Schema::create('pelamar_pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelamar_id');
            $table->string('nama_perusahaan')->nullable();
            $table->string('posisi')->nullable();
            $table->string('tahun_masuk')->nullable();
            $table->string('tahun_keluar')->nullable();
            $table->timestamps();

            $table->foreign('pelamar_id')->references('id_pelamar')->on('pelamar')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelamar_pekerjaan');
        Schema::dropIfExists('pelamar_pendidikan');
        Schema::dropIfExists('pelamar_keluarga');
        
        Schema::table('pelamar', function (Blueprint $table) {
            // Disini harusnya ada dropColumn untuk rollback, tapi dikosongkan dulu tidak masalah untuk dev
        });
    }
}