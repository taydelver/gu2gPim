<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempData extends Model
{
    protected $table = 'temp_data';

    protected $fillable = [
        'data', 'product_id'
    ];
}
