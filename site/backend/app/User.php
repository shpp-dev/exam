<?php

namespace App;

use App\Foundation\BaseModel;
use Carbon\Carbon;

class User extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
    ];

    public function examSessions()
    {
        return $this->hasMany('App\ExamSession');
    }

    public function activeSession()
    {
        return $this->examSessions()
            ->where('finished_at', null)
            ->first();
    }

    public function lastFinishedExamSession()
    {
        return $this->examSessions()
            ->whereNotNull('finished_at')
            ->latest('finished_at')
            ->first();
    }

    public function lastFailedExamSession()
    {
        return $this->examSessions()
            ->whereNotNull('finished_at')
            ->where('passed', 0)
            ->latest('finished_at')
            ->first();
    }

    public function sessionForSpecificDate(Carbon $date)
    {
        return $this->examSessions()
            ->where('created_at', '>', $date->copy()->startOfDay())
            ->where('created_at', '<', $date->copy()->endOfDay())
            ->first();
    }
}
