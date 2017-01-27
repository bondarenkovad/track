<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\IssueStatus;

class Issue extends Model
{
    protected $fillable = [
        'summary', 'description', 'status_id','project_id','type_id', 'priority_id', 'reporter_id',
        'assigned_id','original_estimate', 'remaining_estimate'
    ];

    public function status()
    {
       return $this->hasOne('App\IssueStatus', 'id', 'status_id');
    }

}
