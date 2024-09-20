<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalUmum extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function identitas_koperasi(){
        return $this->belongsTo(IdentitasKoperasi::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function coa(){
        return $this->hasOne(MasterCoa::class,'kode_coa','akun');
    }

    public function master_coa(){
        return $this->hasMany(MasterCoa::class);
    }
}
