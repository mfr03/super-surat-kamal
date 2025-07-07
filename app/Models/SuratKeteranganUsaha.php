<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratKeteranganUsaha extends Model
{
    protected $fillable = [
        'kode_surat',
        'nomor_surat',
        'warga_id',
        'nama_ibu_kandung',
        'nomor_hp',
        'domisili',
        'selama',
        'tujuan_surat'
    ];

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }
}
