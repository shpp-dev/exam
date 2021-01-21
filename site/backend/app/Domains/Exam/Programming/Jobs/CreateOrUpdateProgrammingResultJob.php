<?php

namespace App\Domains\Exam\Programming\Jobs;


use App\ProgrammingResult;
use App\ProgrammingTask;
use Lucid\Foundation\Job;

class CreateOrUpdateProgrammingResultJob extends Job
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
        $programmingResult = ProgrammingResult::where('session_id', $this->sessionId)
            ->where('task_number', $this->task->number)
            ->first();

        if (!$programmingResult) {
            $programmingResult = new ProgrammingResult();
        }

        $programmingResult->sessionId = $this->sessionId;
        $programmingResult->taskNumber = $this->task->number;
        $programmingResult->taskId = $this->task->id;
        $programmingResult->result = json_encode($this->result);
        $programmingResult->save();
    }
}
