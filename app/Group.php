<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Action;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function actions()
    {
        return $this->belongsToMany('App\Action');
    }

    public function getAllActions()
    {
        return $actions = DB::table('actions')
            ->select('actions.name', 'actions.id')
            ->get();
    }

    public function hasAction($action)
    {
        if($this->actions()->where('name', $action)->first())
        {
            return true;
        }

        return false;
    }

    public function addActionToGroup($actionId)
    {
        DB::table('action_group')->insert(
            array('action_id' => $actionId, 'group_id' => $this->id)
        );
    }

    public function deleteActionInGroup($actionId)
    {
        $id = DB::table('action_group')
            ->where('action_group.group_id', '=', $this->id)
            ->where('action_group.action_id', '=', $actionId)
            ->pluck('id');

        DB::table('action_group')->delete($id);
    }

    public function getAllUserWithThisGroup()
    {
       return $users = DB::table('users')
            ->join('group_user', 'users.id', '=', 'group_user.user_id')
            ->join('groups', 'groups.id', '=', 'group_user.group_id')
            ->where('groups.name', '=', $this->name)
            ->select('users.name','users.email','users.active')
//            ->distinct()
            ->get();

    }
}
