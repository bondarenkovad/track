<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Group;
use App\Method;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    public function hasRole()
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

    public function methods()
    {
        return $this->belongsToMany('App\Method');
    }

    public function getActions()
    {
//        return $this->groups()->methods()->get();
//       dd($this->groups()->with('group_method')->get());
//        return DB::table('actions')->get();

        return $actions = DB::table('users')
            ->join('group_user', 'users.id', '=', 'group_user.user_id')
            ->join('groups', 'groups.id', '=', 'group_user.group_id')
            ->join('group_method', 'groups.id', '=', 'group_method.group_id')
            ->join('methods', 'methods.id', '=', 'group_method.method_id')
            ->join('action_method', 'methods.id', '=', 'action_method.method_id')
            ->join('actions', 'actions.id', '=', 'action_method.action_id')
            ->where('users.name', '=', $this->name)
            ->select('users.name', 'actions.name')
            ->get();

//        dd($actions);
    }
}
