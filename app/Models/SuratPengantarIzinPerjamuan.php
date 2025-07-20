<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Constants\DbConst;

class SuratPengantarIzinPerjamuan extends Model
{
    protected $table = DbConst::SURAT_PENGANTAR_IZIN_PERJAMUAN;
    
    protected $fillable = [
        'kode_surat',
        'nomor_surat',
        'jabatan_ttd',
        'warga_id',
        'keperluan',
        'undangan',
        'jenis_pertunjukan',
        'hari_tanggal',
        'berlaku_mulai',
        'keterangan_lain_lain'
    ];

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }
}
