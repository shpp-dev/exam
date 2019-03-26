<?php


namespace App\Domains\ExamSession\Jobs;


use App\Data\ExamSystem;
use App\ExamSession;
use Lucid\Foundation\Job;

class FinishProgrammingExamJob extends Job
{
    private $session;

    public function __construct(ExamSession $session)
    {
        $this->session = $session;
    }

    public function handle()
    {
        $this->session->programmingStatus = ExamSystem::FINISHED_STATUS;
        $this->session->save();
    }
}