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
        $collection = collect();

        if($this->order != null)
        {
            $order = json_decode($this->order);

            $allIssues = Issue::where('project_id', '=', $this->project['id'])
                ->whereIn('id', $order )
                ->get();

            foreach($order as $id)
            {
                foreach($allIssues as $issue)
                {
                    if($issue->id === $id+ 0)
                    {
                        $collection->push($issue);
                    }
                }
            }

            return $collection;
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

    public function isActive()
    {
        if($this->status == 2)
        {
            return true;
        }
        return false;
    }

    public function getNotDoneIssues()
    {
        $issueMass = json_decode($this->order);
        $issueIdMass = [];

        if($this->order != null && $this->order != [])
        {
            $allIssues = Issue::where('project_id', '=', $this->project['id'])
                ->whereIn('id', $issueMass)
                ->get();

            foreach($issueMass as $id)
            {
                foreach($allIssues as $issue)
                {
                    if($issue->id === $id+ 0 && $issue->status_id != 5)
                    {
                        array_push($issueIdMass, "".$issue->id);
                    }
                }
            }

            return $issueIdMass;
        }
        else
        {
            return [];
        }
    }
}
