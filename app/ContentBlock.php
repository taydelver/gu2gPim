<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentBlock extends Model
{
    public function source()
    {
        return $this->morphTo();
    }
}
