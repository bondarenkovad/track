<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Issue;

class IssueType extends Model
{
    protected $fillable = [
        'name'
    ];

    public function issue()
    {
        return $this->belongsTo('App\Issue');
    }
}
