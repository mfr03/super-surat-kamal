<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Constants\DbConst;

class JenisSurat extends Model
{
    protected $table = DbConst::JENIS_SURAT;
    // Undefined, i have no idea tf they're trying to go with this shezaah
    protected $fillable = [
        'name'
    ];


}
