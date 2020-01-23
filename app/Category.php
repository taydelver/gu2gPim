<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'title', 'bc_id', 'parent_id', 'description'
    ];

    protected $primaryKey = 'bc_id';

    public function products()
    {
        return $this->belongsToMany('App\Product', 'category_product');
    }

    public function content_blocks()
    {
        return $this->morphMany('App\ContentBlock', 'source');
    }
}
