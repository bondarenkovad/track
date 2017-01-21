<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Group;
use Illuminate\Support\Facades\DB;

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

    public function hasAnyGroup()
    {
//        dd($this->groups()->exists());

        if( ($this->groups()->exists()) )
        {
            return true;
        }
            return false;
    }

    public function getActions()
    {
//        return $this->groups()->methods()->get();
//       dd($this->groups()->with('group_method')->get());
//        return DB::table('actions')->get();

        return $actions = DB::table('users')
            ->join('group_user', 'users.id', '=', 'group_user.user_id')
            ->join('groups', 'groups.id', '=', 'group_user.group_id')
            ->join('action_group', 'groups.id', '=', 'action_group.group_id')
            ->join('actions', 'actions.id', '=', 'action_group.action_id')
            ->where('users.name', '=', $this->name)
            ->select('users.name', 'actions.name')
            ->distinct()
            ->get();

//        dd($actions);
    }

    public function getAllGroups()
    {
        return $groups = DB::table('groups')
            ->select('groups.name', 'groups.id')
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
//        $groupId = DB::table('groups')->where('name', $groupName)->first()->id;

        DB::table('group_user')->insert(
            array('group_id' => $groupId, 'user_id' => $this->id)
        );
    }

    public function deleteGroupToUser($groupId)
    {
//        $groupId = DB::table('groups')->where('name', $groupName)->first()->id;

        $id = DB::table('group_user')
            ->where('group_user.user_id', '=', $this->id)
            ->where('group_user.group_id', '=', $groupId)
            ->pluck('id');

        DB::table('group_user')->delete($id);
    }
}
