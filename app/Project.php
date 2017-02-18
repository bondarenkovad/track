<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Issue;
use App\Sprint;
use App\User;
use App\IssueStatus;
use App\Board;
use Illuminate\Support\Facades\DB;

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

    public function board()
    {
        return $this->belongsTo('App\Board');
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

        if($orders != null)
        {
            $collection = collect();
            foreach($orders as $id)
            {
                foreach($this->issues()->get() as $issue)
                {
                    if($issue->id === $id+ 0)
                    {
                        $collection->push($issue);
                    }
                }
            }

            return $collection;
        }

        return $this->issues()->get();
    }

    public function getSprints()
    {
        $sprint = $this->sprints()
            ->orderBy('status', 'ASC')
            ->orderBy('created_at', 'ASC')
            ->get();

        return $sprint;
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

    public function hasToDoSprint()
    {
        foreach($this->sprints()->get() as $sprint)
        {
            if($sprint->status === 1)
            {
                return true;
            }
        }
        return false;
    }

    public function getFirstToDoSprint()
    {
        $sprint = $this->sprints()
            ->where('status', '=', '1')
            ->first();

        return $sprint;
    }
}
