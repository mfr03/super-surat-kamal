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
        Schema::create(DbConst::SURAT_PENGANTAR_IZIN_PERJAMUAN, function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->string('jabatan_ttd');
            $table->unsignedBigInteger('warga_id');
            $table->foreign('warga_id')->references('id')->on(DbConst::WARGA);
            $table->string('keperluan');
            $table->string('undangan');
            $table->string('jenis_pertunjukan');
            $table->string('hari-tanggal');
            $table->string('berlaku_mulai');
            $table->string('keterangan_lain_lain');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(DbConst::SURAT_PENGANTAR_IZIN_PERJAMUAN);
    }
};
