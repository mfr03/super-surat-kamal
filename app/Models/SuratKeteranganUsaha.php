<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Constants\DbConst;

class SuratKeteranganUsaha extends Model
{
    protected $table = DbConst::SURAT_KETERANGAN_USAHA;
    
    protected $fillable = [
        'kode_surat',
        'nomor_surat',
        'jabatan_ttd',
        'warga_id',
        'ibu_id',
        'nama_usaha',
        'selama',
        'tujuan_surat'
    ];

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }
}
