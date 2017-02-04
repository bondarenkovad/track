<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Issue;
use App\Sprint;
use App\User;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    protected $fillable = [
        'name', 'key'
    ];

    protected $appends = ['is_status'];
    public function issues()
    {
        return $this->hasMany('App\Issue');
    }

    public function sprints()
    {
        return $this->hasMany('App\Sprint');
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

    public function getIsStatusAttribute()
    {
        return $this->status = [2,45,6] ;
    }

}
