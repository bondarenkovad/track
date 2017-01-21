<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Action;

class Group extends Model
{
    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function actions()
    {
        return $this->belongsToMany('App\Action');
    }
}
