<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FitmentModel extends Model
{
    protected $fillable = [
        'fitment_group_id', 'value'
    ];

    public function fitment_group()
    {
        return $this->belongsTo('App\FitmentGroup');
    }
}
