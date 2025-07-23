<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\DbConst;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(DbConst::WARGA, function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('nama');
            $table->string('jenis_kelamin')->nullable(true);
            $table->date('tanggal_lahir')->nullable(true);
            $table->string('tempat_lahir')->nullable(true);
            $table->string('agama')->nullable(true);
            $table->string('pekerjaan')->nullable(true);
            $table->string('alamat')->nullable(true); 
            $table->string('kartu_keluarga')->nullable(true); 
            $table->string('nomor_hp')->nullable(true);
            $table->string('desa-kelurahan')->nullable(true);
            $table->string('kecamatan')->nullable(true);
            $table->string('kabupaten')->nullable(true);
            $table->string('provinsi')->nullable(true);
            $table->string('kewarganegaraan')->nullable(true);
            $table->string('kebangsaan')->nullable(true);
            $table->date('tanggal_pencatatan_perkawinan')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(DbConst::WARGA);
    }
};
