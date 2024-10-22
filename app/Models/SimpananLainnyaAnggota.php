<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpananLainnyaAnggota extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function anggota_koperasi(){
        return $this->belongsTo(AnggotaKoperasi::class);
    }
}
