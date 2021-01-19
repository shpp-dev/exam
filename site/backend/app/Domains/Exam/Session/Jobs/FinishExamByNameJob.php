<?php


namespace App\Domains\Exam\Session\Jobs;


use App\Data\ExamSystem;
use App\ExamSession;
use Carbon\Carbon;
use Lucid\Foundation\Job;

class FinishExamByNameJob extends Job
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
                $this->session->programmingStatus = ExamSystem::FINISHED_STATUS;
                $this->session->programmingFinishedAt = Carbon::now();
                break;
            case ExamSystem::ENGLISH_EXAM_NAME:
                $this->session->englishStatus = ExamSystem::FINISHED_STATUS;
                $this->session->englishFinishedAt = Carbon::now();
                break;
            case ExamSystem::TYPE_SPEED_EXAM_NAME:
                $this->session->typeSpeedStatus = ExamSystem::FINISHED_STATUS;
        }

        $this->session->save();
    }
}
