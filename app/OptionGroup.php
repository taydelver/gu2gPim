<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionGroup extends Model
{
    protected $fillable = [
        'name', 'type', 'display_name', 'sort_order'
    ];

    public function values()
    {
        return $this->belongsToMany('App\OptionValue')
            ->using('App\OptionGroupValue')
            ->withPivot([
                'sort_order',
                'is_default',
            ])->orderBy('pivot_sort_order', 'asc');
    }

    public function attachedValues()
    {
        $values = $this->values;
        foreach($values as $value) {
            $value->sort_order = $value->pivot->sort_order;
        }
        return $values;
    }
}
