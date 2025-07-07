<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jenazah extends Model
{
    protected $fillable = [
        'warga_id',
        'anak_ke',
        'tanggal_kematian',
        'pukul_kematian',
        'sebab_kematian',
        'tempat_kematian',
        'yang_menerangkan'
    ];

    protected $casts = [
        'tanggal_kematian' => 'date',
    ];
}
