<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $table = 'warga';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nik',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'agama',
        'pekerjaan',
        'alamat',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kewarganegaraan',
        'kebangsaan',
        'tanggal_pencatatan_perkawinan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_pencatatan_perkawinan',
    ];

}
