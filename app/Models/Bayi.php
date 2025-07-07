<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bayi extends Model
{

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'tempat_dilahirkan',
        'tempat_kelahiran',
        'tanggal_lahir',
        'pukul_lahir',
        'jenis_kelahiran',
        'kelahiran_ke',
        'penolong_kelahiran',
        'berat_bayi',
        'panjang_bayi'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'kelahiran_ke' => 'integer',
        'berat_bayi' => 'float',
        'panjang_bayi' => 'float'
    ];
}
