<?php

namespace App\Domains\Exam\Jobs;


use App\ExamSession;
use App\Result;
use App\Task;
use Carbon\Carbon;
use Lucid\Foundation\Job;

class FinishExamSessionJob extends Job
{
    /**
     * @var ExamSession
     */
    private $session;

    public function __construct(ExamSession $session)
    {
        $this->session = $session;
    }

    public function handle()
    {
        $this->session->finishedAt = Carbon::now();
        $this->session->save();
    }
}
