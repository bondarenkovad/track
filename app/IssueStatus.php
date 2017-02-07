<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Issue;
use App\Board;
use App\WorkLog;

class IssueStatus extends Model
{
    protected $fillable = [
        'name'
    ];

    public function issue()
    {
        return $this->belongsTo('App\Issue');
    }

    public function boards()
    {
        return $this->belongsToMany('App\Board');
    }

    public function workLogs()
    {
        return $this->belongsToMany('App\WorkLog');
    }
}
