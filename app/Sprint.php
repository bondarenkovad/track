<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Project;

class Sprint extends Model
{
    protected $fillable = [
        'name', 'description', 'date_start','date_finish',
        'project_id'
    ];

    public function project()
    {
        return $this->hasOne('App\Project', 'id', 'project_id');
    }
}
