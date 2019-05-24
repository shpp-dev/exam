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
        $description = json_decode($this->task->description, true);

        return [
            'name' => $this->task->name,
            'description' => [
                'problem' => $description['problem'],
                'note' => $description['note'],
                'example' => [
                    'input' => $description['example']['input'],
                    'output' => $description['example']['output'],
                ]
            ],
            'number' => $this->task->number,
            'functionStart' => [
                'js' => $this->task->jsStartFunction,
                'java' => $this->task->javaStartFunction,
                'cpp' => $this->task->cppStartFunction
            ],
            'deadlineTs' => Carbon::parse($this->examSession->programmingStartedAt)->addMinutes(config('ptp.programmingExamDurationMins'))->timestamp,
            'tasksAmount' => config('ptp.programmingTasksAmount') + 1
        ];
    }
}
