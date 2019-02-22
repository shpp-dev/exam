<?php

namespace App\Domains\Exam\Jobs;


use App\Result;
use App\Task;
use Lucid\Foundation\Job;

class CreateExamResultJob extends Job
{
    /**
     * @var int
     */
    private $sessionId;

    /**
     * @var Task
     */
    private $task;

    /**
     * @var array
     */
    private $result;

    /**
     * CreateExamResultJob constructor.
     * @param int $sessionId
     * @param Task $task
     * @param array $result
     */
    public function __construct(int $sessionId, Task $task, array $result)
    {
        $this->sessionId = $sessionId;
        $this->task = $task;
        $this->result = $result;
    }

    public function handle()
    {
        $examResult = new Result();
        $examResult->sessionId = $this->sessionId;
        $examResult->taskNumber = $this->task->number;
        $examResult->taskId = $this->task->id;
        $examResult->result = json_encode($this->result);
        $examResult->save();

    }
}
