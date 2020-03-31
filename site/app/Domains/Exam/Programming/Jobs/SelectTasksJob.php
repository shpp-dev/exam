<?php

namespace App\Domains\Exam\Programming\Jobs;


use App\ExamSession;
use App\ProgrammingTask;
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
        if (config('ptp.examOnline')) {
            return [4, 1, 11, 15, 20, 6];
        }

        $tasks = [];

        for ($i= 0; $i <= $this->amount; $i++ ) {
            $task = ProgrammingTask::where('number', $i )->orderByRaw("RAND()")->first();
            $tasks[] = $task->id;
        }

        return $tasks;
    }
}
