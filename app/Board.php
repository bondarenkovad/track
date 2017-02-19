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

    public function deleteStatusToBoard($statusId)
    {
         DB::table('board_issue_status')
            ->where('board_issue_status.board_id', '=', $this->id)
            ->where('board_issue_status.issue_status_id', '=', $statusId)
            ->delete();
    }

    public function filterStatus()
    {
        $filterStatus = [];
        $statusId = [];

        foreach($this->statuses()->get() as $status)
        {
            array_push($statusId,$status->id);
        }

        $allStatuses = IssueStatus::all();
        foreach($allStatuses as $all)
        {
            if(!in_array($all->id, $statusId))
            {
                array_push($filterStatus,$all);
            }
        }

        return $filterStatus;
    }

    public function orderByOrders()
    {
        return $orderBy = DB::table('board_issue_status')
            ->join('boards', 'boards.id', '=', 'board_issue_status.board_id')
            ->join('issue_statuses', 'issue_statuses.id', '=', 'board_issue_status.issue_status_id')
            ->where('boards.id', '=', $this->id)
            ->select('issue_statuses.name', 'board_issue_status.order')
            ->orderBy('board_issue_status.order')
            ->distinct()
            ->get();
    }

    public function widthSizing()
    {
        $count = count($this->statuses()->get());
        $size = 1120/$count;

        return $size;
    }
}
