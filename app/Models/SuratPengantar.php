<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratPengantar extends Model
{
    protected $fillable = [
        'kode_surat',
        'nomor_surat',
        'jabatan_ttd',
        'warga_id',
        'kartu_keluarga',
        'keperluan',
        'tujuan',
        'berlaku_mulai',
        'keterangan',
    ];

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }
}
