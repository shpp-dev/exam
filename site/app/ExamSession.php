<?php

namespace App;

use App\Foundation\BaseModel;

class ExamSession extends BaseModel
{
    protected $fillable = [
        'user_id',
        'started_at',
        'programming_tasks_ids',
        'programming_status',
        'english_status',
        'type_speed_status'
    ];

    public function programmingResults()
    {
        return $this->hasMany('App\ProgrammingResult', 'session_id', 'id');
    }

    public function englishResult()
    {
        return $this->hasOne('App\EnglishResult', 'session_id', 'id');
    }

    public function typeSpeedResult()
    {
        return $this->hasOne('App\TypeSpeedResult', 'session_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
