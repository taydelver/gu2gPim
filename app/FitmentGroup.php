<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FitmentGroup extends Model
{
    protected $fillable = [
        'name', 'store_id'
    ];

    public function fitment_models()
    {
        return $this->hasMany('App\FitmentModel');
    }

    public function models()
    {
        $models = $this->fitment_models;
        foreach( $models as $key => $model ) {
            $model->key_name = $this->name;
        }
        return $models;
    }
}
