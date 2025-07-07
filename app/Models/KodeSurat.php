<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KodeSurat extends Model
{
    protected $fillable = [
        'kode',
        'deskripsi'
    ];

    public function suratKelahiran(): HasMany 
    {
        return $this->hasMany(SuratKelahiran::class);
    }

    public function suratKematian(): HasMany
    {
        return $this->hasMany(SuratKematian::class);
    }

    public function suratKeteranganUsaha(): HasMany
    {
        return $this->hasMany(SuratKeteranganUsaha::class);
    }

    public function suratPengatar(): HasMany
    {
        return $this->hasMany(SuratPengantar::class);
    }

    public function suratPengantarIzinPerjamuan(): HasMany
    {
        return $this->hasMany(SuratPengantarIzinPerjamuan::class);
    }
    
}
