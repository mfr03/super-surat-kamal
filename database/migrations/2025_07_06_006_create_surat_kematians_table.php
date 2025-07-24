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
        Schema::create(DbConst::SURAT_KEMATIAN, function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->string('kode_wilayah');
            $table->string('jabatan_ttd');
            $table->string('nama_kepala_keluarga');
            $table->string('nomor_kepala_keluarga');
            
            $table->unsignedBigInteger('jenazah_id');
            $table->foreign('jenazah_id')->references('id')->on(DbConst::JENAZAH);
            $table->unsignedBigInteger('ibu_id');
            $table->foreign('ibu_id')->references('id')->on(DbConst::WARGA);
            $table->unsignedBigInteger('ayah_id');
            $table->foreign('ayah_id')->references('id')->on(DbConst::WARGA);
            $table->unsignedBigInteger('pelapor_id');
            $table->foreign('pelapor_id')->references('id')->on(DbConst::WARGA);
            $table->unsignedBigInteger('saksi_satu_id');
            $table->foreign('saksi_satu_id')->references('id')->on(DbConst::WARGA);
            $table->unsignedBigInteger('saksi_dua_id');
            $table->foreign('saksi_dua_id')->references('id')->on(DbConst::WARGA);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(DbConst::SURAT_KEMATIAN);
    }
};
