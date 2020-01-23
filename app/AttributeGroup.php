<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{
    protected $fillable = [
        'name', 'category', 'key'
    ];

    public function options()
    {
        return $this->hasMany('App\AttributeOption');
    }
}
