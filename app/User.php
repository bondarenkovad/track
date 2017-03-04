<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Group;
use App\Issue;
use App\Project;
use App\Comment;
use App\Board;
use Illuminate\Support\Facades\DB;
use App\WorkLog;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }

    public function workLogs()
    {
        return $this->belongsToMany('App\WorkLog');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Project');
    }

    public function issue_reporter()
    {
        return $this->hasMany('App\Issue');
    }

    public function comments()
    {
        return $this->hasMany('App\Comments');
    }

    public function issue_assigned()
    {
        return $this->hasMany('App\Issue');
    }

    public function ifAdmin()
    {
        $role = "Administrator";


       $allRoles = $this->groups()->get();

        foreach($allRoles as $group)
            {
                if($group->name === $role)
                {
                    return true;
                }
            }

        return false;
   }

    public function ifPM()
    {
        $role = "PM";


        $allRoles = $this->groups()->get();

        foreach($allRoles as $group)
        {
            if($group->name === $role)
            {
                return true;
            }
        }

        return false;
    }

    public function hasAnyGroup()
    {
        if( ($this->groups()->exists()) )
        {
            return true;
        }
            return false;
    }

    public function getActions()
    {
        return $actions = DB::table('users')
            ->join('group_user', 'users.id', '=', 'group_user.user_id')
            ->join('groups', 'groups.id', '=', 'group_user.group_id')
            ->join('action_group', 'groups.id', '=', 'action_group.group_id')
            ->join('actions', 'actions.id', '=', 'action_group.action_id')
            ->where('users.name', '=', $this->name)
            ->select('users.name', 'actions.name')
            ->distinct()
            ->get();
    }

    public function getAllGroups()
    {
        return $groups = DB::table('groups')
            ->select('groups.name', 'groups.id')
            ->get();
    }

    public function getAllProjects()
    {
        return $projects = DB::table('projects')
            ->select('projects.name', 'projects.id')
            ->get();
    }

    public function hasGroup($group)
    {
        if($this->groups()->where('name', $group)->first())
        {
            return true;
        }

        return false;
    }

    public function addGroupToUser($groupId)
    {
        DB::table('group_user')->insert(
            array('group_id' => $groupId, 'user_id' => $this->id)
        );
    }

    public function addDefaultUserGroup()
    {
        DB::table('group_user')->insert(
            array('group_id' => 2, 'user_id' => $this->id)
        );
    }

    public function deleteGroupToUser($groupId)
    {
        $id = DB::table('group_user')
            ->where('group_user.user_id', '=', $this->id)
            ->where('group_user.group_id', '=', $groupId)
            ->pluck('id');

        DB::table('group_user')->delete($id);
    }

    public function hasAnyProject()
    {
        if( ($this->projects()->exists()) )
        {
            return true;
        }
        return false;
    }

    public function hasProject($project)
    {
        if($this->projects()->where('name', $project)->first())
        {
            return true;
        }

        return false;
    }

    public function addInProject($projectId)
    {
        DB::table('project_user')->insert(
            array('project_id' => $projectId, 'user_id' => $this->id)
        );
    }

    public function deleteOfProject($projectId)
    {
        $id = DB::table('project_user')
            ->where('project_user.user_id', '=', $this->id)
            ->where('project_user.project_id', '=', $projectId)
            ->pluck('id');

        DB::table('project_user')->delete($id);
    }

    public function getUserIssues()
    {
        $projectIds = $this->projects()->get()->pluck('id');

        $issues = Issue::where([
                ['reporter_id', '=', $this->id],
                ['assigned_id', '=', $this->id]
        ])
            ->whereNotIn('project_id', $projectIds)
            ->get();

        return $issues;
    }

    public function getUserProjects()
    {
        return $projects = $this->projects()->get();
    }

    public function getUserBoards()
    {
        $projectIds = $this->projects()->get()->pluck('id');

       return $boards = Board::whereIn('project_id', $projectIds)
           ->get();
    }
}
