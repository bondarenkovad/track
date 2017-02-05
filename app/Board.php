<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;

class Board extends Model
{
    protected $fillable = [
        'name', 'project_id'
    ];

    public function project()
    {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }
}
