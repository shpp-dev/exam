<?php

namespace App;

use App\Foundation\BaseModel;

class ExamSession extends BaseModel
{
    protected $fillable = [
        'user_id',
        'started_at',
        'tasks_ids'
    ];

    public function results()
    {
        return $this->hasMany('App\Result', 'session_id');
    }
}
