<?php

namespace App\Domains\Exam\Session\Jobs;


use App\ExamSession;
use Carbon\Carbon;
use Lucid\Foundation\Job;

class FinishSessionJob extends Job
{
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
