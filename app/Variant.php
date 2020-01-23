<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = [
        'sku', 'bc_id', 'calculated_price', 'product_id'
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
