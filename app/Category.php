<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'detail'
    ];

    public function stuff()
    {
        return $this->belongsTo('App\Stuff');
    }
}
