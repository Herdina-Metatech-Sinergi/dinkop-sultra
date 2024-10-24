<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpananNonModalData extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function simpanan_non_modal_menu(){
        return $this->belongsTo(SimpananNonModalMenu::class,'menu_id','id');
    }
}
