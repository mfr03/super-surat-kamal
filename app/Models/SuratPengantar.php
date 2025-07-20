<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Constants\DbConst;

class SuratPengantar extends Model
{
    protected $table = DbConst::SURAT_PENGANTAR;
    
    protected $fillable = [
        'kode_surat',
        'nomor_surat',
        'jabatan_ttd',
        'warga_id',
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
