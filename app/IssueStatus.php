<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Issue;

class IssueStatus extends Model
{
    protected $fillable = [
        'name'
    ];

    public function issue()
    {
        return $this->belongsTo('App\Issue');
    }
}
