<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Group;

class Action extends Model
{
    public function methods()
    {
        return $this->hasMany('App\Group');
    }
}
