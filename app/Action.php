<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Property_Group;

class Action extends Model
{
    public function property_groups()
    {
        return $this->hasMany('App\Property_Group');
    }
}
