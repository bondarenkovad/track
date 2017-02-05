<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Issue;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    protected $fillable = [
        'text', 'issue_id','user_id'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function issue()
    {
        return $this->hasOne('App\Issue', 'id', 'issue_id');
    }
}
