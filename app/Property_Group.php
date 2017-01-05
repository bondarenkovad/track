<?php

namespace App;

use App\Action;
use App\Group;
use Illuminate\Database\Eloquent\Model;

class Property_Group extends Model
{
    public function actions()
    {
        return $this->hasMany('App\Action');
    }

    public function propGroup()
    {
        return $this->hasOne('App\Group');
    }
}
