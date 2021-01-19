<?php


namespace App\Domains\Exam\Session\Jobs;


use App\Data\ExamSystem;
use App\ExamSession;
use Carbon\Carbon;
use Lucid\Foundation\Job;

class StartExamByNameJob extends Job
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
                $this->session->programmingStartedAt = Carbon::now();
                $this->session->programmingStatus = ExamSystem::IN_PROGRESS_STATUS;
                break;
            case ExamSystem::ENGLISH_EXAM_NAME:
                $this->session->englishStartedAt = Carbon::now();
                $this->session->englishStatus = ExamSystem::IN_PROGRESS_STATUS;
                break;
            case ExamSystem::TYPE_SPEED_EXAM_NAME:
                $this->session->typeSpeedStatus = ExamSystem::IN_PROGRESS_STATUS;
                break;
        }

        $this->session->save();
    }
}
