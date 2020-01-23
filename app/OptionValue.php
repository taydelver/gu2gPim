<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    protected $fillable = [
        'label', 'sort_order', 'is_default', 'category_id', 'value_data'
    ];

    public function category()
    {
        return $this->belongsTo('App\OptionValueCategory');
    }
}
