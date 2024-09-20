<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonfigurasiCOA extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function master_coa(){
        return $this->hasMany(MasterCoa::class);
    }

    public function coa(){
        return $this->belongsTo(MasterCoa::class,'kode_coa','akun');
    }
}
