<?php

namespace App\Domains\Data\Jobs;


use App\ExamSession;
use App\ProgrammingTask;
use Carbon\Carbon;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Lucid\Foundation\Job;

class GetPreparedTaskDataJob extends Job
{
    /**
     * @var ProgrammingTask
     */
    private $task;

    /**
     * @var ExamSession
     */
    private $examSession;

    /**
     * GetPreparedTaskDataJob constructor.
     * @param ProgrammingTask $task
     * @param ExamSession $examSession
     */
    public function __construct(ProgrammingTask $task, ExamSession $examSession)
    {
        $this->task = $task;
        $this->examSession = $examSession;
    }

    public function handle()
    {
        return [
            'name' => $this->task->name,
            'description' => $this->task->description,
            'number' => $this->task->number,
            'functionStart' => [
                'js' => $this->task->jsStartFunction,
                'java' => $this->task->javaStartFunction,
                'cpp' => $this->task->cppStartFunction
            ],
            'deadlineTs' => Carbon::parse($this->examSession->startedAt)->addMinutes(config('ptp.examDurationMins'))->timestamp
        ];
    }
}
