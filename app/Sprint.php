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

    public function SortIssueByOrder()
    {
        if($this->order != null)
        {
            $allIssues = Issue::where('project_id', '=', $this->project['id'])->get();

            $order = json_decode($this->order);
            $collection = collect();

            foreach($order as $id)
            {
                foreach($allIssues as $issue)
                {
                    if($issue->id === $id+0)
                    {
                        $collection->push($issue);
                    }
                }
            }

            return $collection;
        }

        return $collection = [];
    }
}
