<?php

namespace App\Domains\Exam\Jobs;


use App\ExamSession;
use App\Task;
use Carbon\Carbon;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Lucid\Foundation\Job;

class SelectTasksJob extends Job
{
    /**
     * @var int
     */
    private $amount;

    /**
     * SelectTasksJob constructor.
     * @param int $amount
     */
    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return array
     */
    public function handle()
    {
        $tasks = [];
        for ($i= 0; $i <= $this->amount; $i++ ) {
            $task = Task::where('taskNumber', $i )->orderByRaw("RAND()")->get();
            $tasks[] = $task[0]->id;
        }
        return $tasks;
    }
}
