<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeOption extends Model
{
    protected $fillable = [
        'value', 'attribute_group_id'
    ];

    public function attribute_group()
    {
        return $this->belongsTo('App\AttributeGroup');
    }
}
