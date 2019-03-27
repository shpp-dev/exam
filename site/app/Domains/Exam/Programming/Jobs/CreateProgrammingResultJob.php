<?php

namespace App\Domains\Exam\Programming\Jobs;


use App\ProgrammingResult;
use App\ProgrammingTask;
use Lucid\Foundation\Job;

class CreateProgrammingResultJob extends Job
{
    /**
     * @var int
     */
    private $sessionId;

    /**
     * @var ProgrammingTask
     */
    private $task;

    /**
     * @var array
     */
    private $result;

    /**
     * CreateExamResultJob constructor.
     * @param int $sessionId
     * @param ProgrammingTask $task
     * @param array $result
     */
    public function __construct(int $sessionId, ProgrammingTask $task, array $result)
    {
        $this->sessionId = $sessionId;
        $this->task = $task;
        $this->result = $result;
    }

    public function handle()
    {
        $examResult = new ProgrammingResult();
        $examResult->sessionId = $this->sessionId;
        $examResult->taskNumber = $this->task->number;
        $examResult->taskId = $this->task->id;
        $examResult->result = json_encode($this->result);
        $examResult->save();
    }
}
