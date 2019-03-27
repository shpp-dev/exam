<?php


namespace App\Domains\Exam\Session\Jobs;


use App\Data\ExamSystem;
use App\ExamSession;

class CheckAllExamsFinishedJob
{
    private $session;

    public function __construct(ExamSession $session)
    {
        $this->session = $session;
    }

    public function handle()
    {
        if ($this->session->programmingStatus == ExamSystem::IN_PROGRESS_STATUS) {
            return false;
        }

        if ($this->session->englishStatus == ExamSystem::IN_PROGRESS_STATUS) {
            return false;
        }

        if ($this->session->typeSpeedStatus == ExamSystem::IN_PROGRESS_STATUS) {
            return false;
        }

        return true;
    }
}