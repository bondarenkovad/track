<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Method;

class Action extends Model
{
    public function methods()
    {
        return $this->hasMany('App\Method');
    }
}
