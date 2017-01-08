<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Method;

class Group extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function methods()
    {
        return $this->belongsToMany('App\Method');
    }
}
