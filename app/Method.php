<?php

namespace App;

use App\Action;
use App\Group;
use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
    public function actions()
    {
        return $this->hasMany('App\Action');
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }
}
