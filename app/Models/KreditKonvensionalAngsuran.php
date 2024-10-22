<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KreditKonvensionalAngsuran extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function kredit_konvensional(){
        return $this->belongsTo(KreditKonvensional::class);
    }
}
