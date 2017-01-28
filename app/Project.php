<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Issue;

class Project extends Model
{
    protected $fillable = [
        'name', 'key'
    ];

    public function issue()
    {
        return $this->hasMany('App\Issue');
    }
}
