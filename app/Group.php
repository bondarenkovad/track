<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Property_Group;

class Group extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function propGroup()
    {
        return $this->hasOne('App\Property_Group');
    }
}
