<?php

namespace App\Models;

use App\Constants\DbConst;
use Illuminate\Database\Eloquent\Model;

class Pejabat extends Model
{
    protected $table = DbConst::PEJABAT;

    protected $fillable = [
        'nama',
        'jabatan',
        'alamat',
    ];

    
}
