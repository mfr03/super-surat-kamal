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
        Schema::create(DbConst::SURAT_KETERANGAN_USAHA, function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->string('jabatan_ttd');
            $table->unsignedBigInteger('warga_id');
            $table->foreign('warga_id')->references('id')->on(DbConst::WARGA);
            $table->string('nama_ibu_kandung');
            $table->string('nomor_hp');
            $table->string('domisili');
            $table->string('selama');
            $table->string('tujuan_surat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(DbConst::SURAT_KETERANGAN_USAHA);
    }
};
