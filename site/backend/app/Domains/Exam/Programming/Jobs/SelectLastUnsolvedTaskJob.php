<?php

namespace App\Domains\Exam\Programming\Jobs;


use App\Domains\Helpers\Traits\MappedTrait;
use App\ExamSession;
use Lucid\Foundation\Job;

class SelectLastUnsolvedTaskJob extends Job
{
    use MappedTrait;

    private $examSession;

    public function __construct(ExamSession $examSession)
    {
        $this->examSession = $examSession;
    }

    public function handle()
    {
        $tasks = json_decode($this->examSession->programmingTasksIds);
        $mappedResults = $this->getMapped($this->examSession->programmingResults()->get(), 'taskId');

        $unsolvedId = 1;
        foreach ($tasks as $task) {
            if (!isset($mappedResults[$task])) {
                $unsolvedId = $task;
                break;
            }
        }
        return $unsolvedId;
    }
}
