<?php


namespace App\Domains\Exam\Session\Jobs;


use App\Data\ExamSystem;
use App\ExamSession;
use Carbon\Carbon;
use Lucid\Foundation\Job;

class GetRestOfExamTimeJob extends Job
{
    /**
     * @var ExamSession
     */
    private $examSession;

    /**
     * @var string
     */
    private $examType;

    public function __construct(ExamSession $examSession, string $examType)
    {
        $this->examSession = $examSession;
        $this->examType = $examType;
    }

    public function handle()
    {
        switch ($this->examType) {
            case ExamSystem::PROGRAMMING_EXAM_NAME:
                $startExamInSeconds = Carbon::parse($this->examSession->programming_started_at)->timestamp;
                $durationInMinutes = config('ptp.programmingExamDurationMins');
                break;
            case ExamSystem::ENGLISH_EXAM_NAME:
                $startExamInSeconds = Carbon::parse($this->examSession->english_started_at)->timestamp;
                $durationInMinutes = config('ptp.englishExamDurationMins');
                break;
            default:
                throw new \Exception('Unknown exam type');
        }

        $nowInSeconds = Carbon::now()->timestamp;
        $subInSeconds = $nowInSeconds - $startExamInSeconds;
        $restInSeconds = $durationInMinutes * 60 - $subInSeconds;

        return $restInSeconds > 0 ? $restInSeconds : 0;
    }
}
