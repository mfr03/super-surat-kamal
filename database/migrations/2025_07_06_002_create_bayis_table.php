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
        Schema::create(DbConst::BAYI, function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->string('tempat_dilahirkan');
            $table->string('tempat_kelahiran');
            $table->date('tanggal_lahir');
            $table->time('pukul_lahir');
            $table->string('jenis_kelahiran');
            $table->integer('kelahiran_ke');
            $table->string('penolong_kelahiran');
            $table->integer('berat_bayi');
            $table->integer('panjang_bayi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(DbConst::BAYI);
    }
};
