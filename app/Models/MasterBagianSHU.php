<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBagianSHU extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function identitas_koperasi(){
        return $this->belongsTo(IdentitasKoperasi::class);
    }
}
