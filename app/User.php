<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Group;

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

//        if(is_array($allRoles))
//        {
//            foreach($allRoles as $group)
//            {
//                echo $group->name;
//            }
//        }
//        else if(is_string($allRoles))
//        {
//            echo $allRoles;
//        }
//        else
//        {
//            echo "Что то другое вернулось!";
//        }
//        $role = "Administrator";
//
//        $u = $this->groups()->get();
//
//        if(is_array($u))
//        {
//            foreach($u as $group)
//            {
//                if($group->name === $role)
//                {
//                    return true;
//                }
////                echo $group->name;
//            }
//        }
//        else
//        {
//            if($u === $role)
//            {
//                return true;
//            }
//        }
//
//        return false;

//        dd($this->groups()->get());
//        foreach($this->groups() as $group)
//        {
//            dd($group);
//        }
//      echo $this->groups()->find();

//        if($this->hasRole())
//        {
//
//        }

//        if(is_array($this->groups()))
//        {
//            foreach($this->groups() as $group)
//            {
//                if($group->where('name', $role)->first())
//                {
//                    return true;
//                }
//            }
//        }
//        else
//        {
//            if($this->groups()->where('name', $role)->first())
//            {
//                return true;
//            }
//        }
//
//
//        return false;
   }
}
