<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Issue;
use Illuminate\Support\Facades\DB;
use App\IssueStatus;

class WorkLog extends Model
{
    protected $fillable = [
        'comment', 'issue_id', 'user_id', 'time_spent', 'issue_status_id'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function issue()
    {
        return $this->hasOne('App\Issue', 'id', 'issue_id');
    }

    public function status()
    {
        return $this->hasOne('App\IssueStatus', 'id', 'issue_status_id');
    }
}
