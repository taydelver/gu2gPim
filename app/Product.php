<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'bc_id', 'availability', 'brand_id', 'calculated_price', 'inventory_level', 'is_featured', 'is_visible', 'sku', 'price', 'base_variant_id'
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_product');
    }

    public function custom_fields()
    {
        return $this->belongsToMany('App\CustomField', 'custom_field_product');
    }
}
