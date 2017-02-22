<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;
use App\Issue;
use Illuminate\Support\Facades\DB;

class Sprint extends Model
{
    protected $fillable = [
        'name', 'description', 'status','date_start','date_finish',
        'project_id'
    ];

    public function project()
    {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }

    public function getIssueForSprint()
    {
        if($this->order != null)
        {
            $order = json_decode($this->order);

            $allIssues = Issue::where('project_id', '=', $this->project['id'])
                ->whereIn('id', $order )
                ->get();

            return $allIssues;
        }
        return [];
    }

    public function getIssueByStatus($id)
    {
        if($this->order != null)
        {
            $order = json_decode($this->order);

            $issues = Issue::where('project_id', '=', $this->project['id'])
                ->whereIn('id', $order )
                ->where('status_id', '=', $id)
                ->get();

            return $issues;
        }

        return [];
    }

    public function isActiveSprint()
    {
        if($this->status === 2)
        {
            return true;
        }
        return false;
    }
}
