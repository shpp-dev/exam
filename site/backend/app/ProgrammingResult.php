<?php

namespace App;

use App\Foundation\BaseModel;

class ProgrammingResult extends BaseModel
{
    public function task()
    {
        return $this->hasOne('App\ProgrammingTask', 'id', 'task_id');
    }
}
