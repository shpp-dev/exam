<?php

namespace App;

use App\Foundation\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Result extends BaseModel
{
    public function task()
    {
        return $this->hasOne('App\Task', 'id', 'task_id');
    }
}
