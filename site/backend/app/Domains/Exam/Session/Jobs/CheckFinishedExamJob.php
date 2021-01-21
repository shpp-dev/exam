<?php


namespace App\Domains\Exam\Session\Jobs;


use App\Data\ExamSystem;
use App\ExamSession;
use Lucid\Foundation\Job;

class CheckFinishedExamJob extends Job
{
    private $session;
    private $examName;

    public function __construct(ExamSession $session, string $examName)
    {
        $this->session = $session;
        $this->examName = $examName;
    }

    public function handle()
    {
        switch ($this->examName) {
            case ExamSystem::PROGRAMMING_EXAM_NAME:
                return $this->session->programmingStatus == ExamSystem::FINISHED_STATUS;
            case ExamSystem::ENGLISH_EXAM_NAME:
                return $this->session->englishStatus == ExamSystem::FINISHED_STATUS;
            default:
                return false;
        }
    }
}