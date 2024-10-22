<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KreditAngsuran extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kredit(){
        return $this->belongsTo(Kredit::class);
    }
}
