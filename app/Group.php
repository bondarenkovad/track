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
}
