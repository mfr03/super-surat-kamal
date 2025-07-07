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
        Schema::create(DbConst::JENAZAH, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warga_id');
            $table->foreign('warga_id')->references('id')->on(DbConst::WARGA);
            $table->string('anak_ke');
            $table->string('tanggal_kematian');
            $table->string('pukul_kematian');
            $table->string('sebab_kematian');
            $table->string('tempat_kematian');
            $table->string('yang_menerangkan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(DbConst::JENAZAH);
    }
};
