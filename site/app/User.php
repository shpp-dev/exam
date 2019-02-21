<?php

namespace App;

use App\Foundation\BaseModel;
use Illuminate\Notifications\Notifiable;

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
        return $this->examSessions()->where('finished_at', null)->first();
    }
}
