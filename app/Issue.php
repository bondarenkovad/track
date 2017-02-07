<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\IssueStatus;
use App\Project;
use App\IssueType;
use App\IssuesPriority;
use App\User;
use App\Comment;
use App\WorkLog;
use Illuminate\Support\Facades\DB;

class Issue extends Model
{
    protected $fillable = [
        'summary', 'description', 'status_id','project_id','type_id', 'priority_id', 'reporter_id',
        'assigned_id','original_estimate', 'remaining_estimate'
    ];

    public function status()
    {
       return $this->hasOne('App\IssueStatus', 'id', 'status_id');
    }

    public function project()
    {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }

    public function type()
    {
        return $this->hasOne('App\IssueType', 'id', 'type_id');
    }

    public function priority()
    {
        return $this->hasOne('App\IssuesPriority', 'id', 'priority_id');
    }

    public function reporter()
    {
        return $this->hasOne('App\User', 'id', 'reporter_id');
    }

    public function assigned()
    {
        return $this->hasOne('App\User', 'id', 'assigned_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function workLogs()
    {
        return $this->belongsToMany('App\WorkLog');
    }

    public function getThisComments()
    {
        return $comments = DB::table('comments')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->join('issues', 'issues.id', '=', 'comments.issue_id')
            ->where('comments.issue_id', '=', $this->id)
            ->select('comments.text', 'users.name', 'comments.id')
            ->distinct()
            ->get();
    }

    public function getThisLogs()
    {
        return $logs = DB::table('work_logs')
            ->join('users', 'users.id', '=', 'work_logs.user_id')
            ->join('issues', 'issues.id', '=', 'work_logs.issue_id')
            ->join('issue_statuses', 'issue_statuses.id', '=', 'work_logs.issue_status_id')
            ->where('work_logs.issue_id', '=', $this->id)
            ->select('work_logs.comment', 'users.name as user', 'issue_statuses.name as status','work_logs.time_spent', 'work_logs.id')
            ->distinct()
            ->get();
    }

    public function CountComments()
    {
        if($this->comments()->exists())
        {
            return count($this->comments());
        }

        return 0;
    }
}
