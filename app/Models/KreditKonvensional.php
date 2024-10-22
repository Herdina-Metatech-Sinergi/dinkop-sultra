<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KreditKonvensional extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function kredit_konvensional_angsuran(){
        return $this->hasMany(KreditKonvensionalAngsuran::class,'kredit_konvensional_id','id');
    }

    public function anggota_koperasi(){
        return $this->belongsTo(AnggotaKoperasi::class);
    }
}
