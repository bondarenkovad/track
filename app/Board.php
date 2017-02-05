<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;
use App\IssueStatus;

class Board extends Model
{
    protected $fillable = [
        'name', 'project_id'
    ];

    public function project()
    {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }

    public function statuses()
    {
        return $this->belongsToMany('App\IssueStatus');
    }
}
