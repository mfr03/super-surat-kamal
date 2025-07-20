<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Constants\DbConst;
class Warga extends Model
{
    protected $table = DbConst::WARGA;

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
        'nomor_hp',
        'kartu_keluarga',
        'desa-kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kewarganegaraan',
        'kebangsaan',
        'tanggal_pencatatan_perkawinan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_pencatatan_perkawinan' => 'date',
    ];

}
