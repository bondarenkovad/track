<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Issue;
use App\Sprint;
use App\User;
use App\IssueStatus;
use App\Board;
use Illuminate\Support\Facades\DB;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class Project extends Model
{
    protected $fillable = [
        'name', 'key'
    ];

    public function issues()
    {
        return $this->hasMany('App\Issue');
    }

    public function sprints()
    {
        return $this->hasMany('App\Sprint');
    }

    public function countIssues()
    {
        return count($this->issues()->get());
    }

    public function boards()
    {
        return $this->hasMany('App\Board');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function getAllUsers()
    {
        return $users = DB::table('users')
            ->select('users.name', 'users.id')
            ->get();
    }

    public function getAllStatuses()
    {
        return $users = DB::table('issue_statuses')
            ->select('issue_statuses.name', 'issue_statuses.id')
            ->get();
    }

    public function hasUserInProject($user)
    {
        if($this->users()->where('name', $user)->first())
        {
            return true;
        }

        return false;
    }

    public function addUserToProject($userId)
    {
        DB::table('project_user')->insert(
            array('user_id' => $userId, 'project_id' => $this->id)
        );
    }

    public function deleteUserOfProject($userId)
    {
        $id = DB::table('project_user')
            ->where('project_user.user_id', '=', $userId)
            ->where('project_user.project_id', '=', $this->id)
            ->pluck('id');

        DB::table('project_user')->delete($id);
    }

    public function SortIssueByOrder()
    {
        $orders = json_decode($this->order);
        $idIssueInSprint = [];
        $collection = collect();

        foreach($this->sprints()->get() as $sprint)
        {
            if($sprint->order != null)
            {
                $idIssueInSprint = array_merge( $idIssueInSprint, json_decode($sprint->order));
            }
        }

        if($orders != null)
        {
            $count = 0;
            foreach($orders as $id)
            {
                foreach($this->issues()->get() as $issue)
                {
                    if($issue->id === $id+ 0 && !in_array($issue->id, $idIssueInSprint))
                    {
                        $collection->push($issue);
                    }

                    if(!in_array($issue->id, $idIssueInSprint) && !in_array($issue->id, $orders))
                    {
                        if($count === 0)
                        {
                            $collection->push($issue);
                            $count++;
                        }
                    }
                }
            }
            return $collection;
        }
        else
        {
            foreach($this->issues()->get() as $issue)
            {
                if (!in_array($issue->id, $idIssueInSprint))
                {
                    $collection->push($issue);
                }
            }

            if($collection != null)
            {
                return $collection;
            }
            else
            {
                return [];
            }
        }
    }

    public function getSprints()
    {
        $sprints = $this->sprints()
            ->orderBy('status', 'DESC')
            ->orderBy('date_start', 'DESC')
            ->get();

        return $sprints;
    }

    public function hasSprints()
    {
        $sprints = $this->sprints()
            ->where('status','<>',0)
            ->count();

        if($sprints)
        {
            return true;
        }

        return false;
    }

    public function getIssueForUserById($id)
    {
        return $issues = Issue::
                 where('project_id', '=', $this->id)
                ->where('assigned_id', '=', $id)
                ->get();
    }

    public function getBacklogTime()
    {
        $time = 0;
        $order = json_decode($this->order);

        $issues = Issue::whereIn('id', $order)
            ->get();

        foreach($issues as $issue)
        {
            $time+= $issue->calcRE();
        }

        if($time != null)
        {
            return $time;
        }
        else
        {
            return 0;
        }
    }

    public function getBacklogOE()
    {
        $issues = json_decode($this->order);

        $time = Issue::whereIn('id', $issues)
            ->sum('original_estimate');

        if($time != null)
        {
            return $time;
        }
        else
        {
            return 0;
        }
    }

    public function getSprintTime($sprintId)
    {
        $time = 0;
        $sprint = Sprint::find($sprintId);
        $orders = json_decode($sprint->order);

        $issues = Issue::whereIn('id', $orders)
            ->get();

        foreach($issues as $issue)
        {
            $time+= $issue->calcRE();
        }

        if($time != null)
        {
            return $time;
        }
        else
        {
            return 0;
        }
    }

    public function getSprintOE($sprintId)
    {
        $sprint = Sprint::find($sprintId);
        $issues = json_decode($sprint->order);

        $time = Issue::whereIn('id', $issues)
            ->sum('original_estimate');

        if($time != null)
        {
            return $time;
        }
        else
        {
            return 0;
        }
    }

    public function getUserInProjectTime($userId)
    {
        $time = 0;
        $issues = Issue::where('project_id', '=', $this->id)
            ->where('assigned_id', '=', $userId)
            ->get();

        foreach($issues as $issue)
        {
            $time+= $issue->calcRE();
        }


        if($time != null)
        {
            return $time;
        }
        else
        {
            return 0;
        }
    }

    public function getUserInProjectOE($userId)
    {
        $time = Issue::where('project_id', '=', $this->id)
            ->where('assigned_id', '=', $userId)
            ->sum('original_estimate');

        if($time != null)
        {
            return $time;
        }
        else
        {
            return 0;
        }
    }

    public function getProjectTime()
    {
        $time = 0;
         $issues = Issue::where('project_id', '=', $this->id)
            ->get();

        foreach($issues as $issue)
        {
            $time+= $issue->calcRE();
        }

        if($time != null)
        {
            return $time;
        }
        else
        {
            return 0;
        }
    }

    public function getProjectOE()
    {
         $time = Issue::where('project_id', '=', $this->id)
            ->sum('original_estimate');

        if($time != null)
        {
            return $time;
        }
        else
        {
            return 0;
        }
    }

}
