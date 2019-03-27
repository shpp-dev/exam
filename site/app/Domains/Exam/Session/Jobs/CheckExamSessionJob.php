<?php

namespace App\Domains\Exam\Session\Jobs;


use App\ExamSession;
use App\ProgrammingResult;
use App\ProgrammingTask;
use Carbon\Carbon;
use Lucid\Foundation\Job;

class CheckExamSessionJob extends Job
{
    /**
     * @var ExamSession
     */
    private $session;

    /**
     * @var bool
     */
    private $passed;

    public function __construct(ExamSession $session, bool $passed)
    {
        $this->session = $session;
        $this->passed = $passed;
    }

    public function handle()
    {
        $this->session->passed = $this->passed;
        $this->session->save();
    }
}
