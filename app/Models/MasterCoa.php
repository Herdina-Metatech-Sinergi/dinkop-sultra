<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SolutionForest\FilamentTree\Concern\ModelTree;

class MasterCoa extends Model
{
    use HasFactory;
    use ModelTree;


    protected $guarded = [];

    public function parent(){
        return $this->BelongsTo(MasterCoa::class);
    }


    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->with("children");
    }

    public function self()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }
}
