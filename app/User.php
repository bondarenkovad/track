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

    public function getMethod()
    {
//        return $this->groups()->methods()->get();
//       dd($this->groups()->with('group_method')->get());
        return DB::table('actions')->get();
    }
}
