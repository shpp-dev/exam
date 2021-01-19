<?php


namespace App\Domains\Exam\Session\Jobs;


use App\Data\ExamSystem;
use App\ExamSession;
use Lucid\Foundation\Job;

class CheckActiveExamJob extends Job
{
    private $session;

    public function __construct(ExamSession $session)
    {
        $this->session = $session;
    }

    public function handle()
    {
        if ($this->session->programmingStatus == ExamSystem::IN_PROGRESS_STATUS
            || $this->session->englishStatus == ExamSystem::IN_PROGRESS_STATUS
            || $this->session->typeSpeedStatus == ExamSystem::IN_PROGRESS_STATUS) {
            return true;
        }

        return false;
    }
}
