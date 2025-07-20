<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Constants\DbConst;

class SuratKelahiran extends Model
{
    protected $table = DbConst::SURAT_KELAHIRAN;
    
    protected $fillable = [
        'kode_surat_id',
        'nomor_surat',
        'jabatan_ttd',
        'nama_kepala_keluarga',
        'nomor_kepala_keluarga',
        'bayi_id',
        'ibu_id',
        'ayah_id',
        'pelapor_id',
        'saksi_satu_id',
        'saksi_dua_id'
    ];

    public function kodeSurat(): BelongsTo
    {
        return $this->belongsTo(KodeSurat::class, 'kode_surat_id');
    }

    public function bayi(): BelongsTo
    {
        return $this->belongsTo(Bayi::class, 'bayi_id');
    }

    public function ibu(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'ibu_id');
    }

    public function ayah(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'ayah_id');
    }

    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'pelapor_id');
    }

    public function saksiSatu(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'saksi_satu_id');
    }

    public function saksiDua(): BelongsTo 
    {
        return $this->belongsTo(Warga::class, 'saksi_dua_id');
    }
}
