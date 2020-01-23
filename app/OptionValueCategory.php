<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionValueCategory extends Model
{
    protected $fillable = [
        'name', 'slug'
    ];

    public function values()
    {
        return $this->hasMany('App\OptionValue', 'category_id');
    }
}
