<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Issue;
use App\Sprint;

class Project extends Model
{
    protected $fillable = [
        'name', 'key'
    ];

    public function issues()
    {
        return $this->hasMany('App\Issue');
    }
    public function sprints()
    {
        return $this->hasMany('App\Sprint');
    }

}
