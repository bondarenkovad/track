<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;
use App\IssueStatus;
use Illuminate\Support\Facades\DB;

class Board extends Model
{
    protected $fillable = [
        'name', 'project_id'
    ];

    public function project()
    {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }

    public function statuses()
    {
        return $this->belongsToMany('App\IssueStatus');
    }

    public function hasStatus($status)
    {
        if($this->statuses()->where('name', $status)->first())
        {
            return true;
        }

        return false;
    }

    public function addStatusToBoard($statusId, $key)
    {
        DB::table('board_issue_status')->insert(
            array('issue_status_id' => $statusId, 'board_id' => $this->id, 'order'=>$key)
        );
    }
}
