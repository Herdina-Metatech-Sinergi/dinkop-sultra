<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kredit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kredit_angsuran(){
        return $this->hasMany(KreditAngsuran::class,'kredit_id','id');
    }
}
