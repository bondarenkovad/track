<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\IssueStatus;
use App\Project;
use App\IssueType;
use App\IssuesPriority;
use App\User;

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
}
