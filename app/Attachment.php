<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Issue;

class Attachment extends Model
{
    protected $fillable = [
        'path', 'issue_id'
    ];

    public function issue()
    {
        return $this->hasOne('App\Issue', 'id', 'issue_id');
    }
}
