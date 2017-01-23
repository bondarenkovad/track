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
}
