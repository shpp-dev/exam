<?php


namespace App\Domains\User\Jobs;


use App\Data\ExamSystem;
use App\User;
use Carbon\Carbon;
use Lucid\Foundation\Job;

class GetExamStatusForUserJob extends Job
{
    /**
     * @var User|null
     */
    private $user;

    public function __construct(?User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        if ($this->user === null) {
            return ExamSystem::EXAM_NOT_AVAILABLE;
        }

        if ($this->user->exam_datetime === null) {
            return ExamSystem::EXAM_REGISTRATION_AVAILABLE;
        }

        $examDate = Carbon::parse($this->user->exam_datetime)->startOfDay();
        $today = Carbon::now()->addDay()->startOfDay();
        $activeSession = $this->user->activeSession();
        $lastFinishedExamSession = $this->user->lastFinishedExamSession();
        $lastExamFinishDate = null;

        if ($lastFinishedExamSession) {
            $lastExamFinishDate = Carbon::parse($lastFinishedExamSession->finished_at)->startOfDay();
        }

        if ($today < $examDate) {
            return ExamSystem::EXAM_PENDING;
        } elseif ($today->equalTo($examDate) && !$activeSession && $today->notEqualTo($lastExamFinishDate)) {
            return ExamSystem::EXAM_AVAILABLE;
        } elseif ($activeSession) {
            return ExamSystem::EXAM_PROGRESS;
        }

        if ($lastFinishedExamSession->passed === null) {
            return ExamSystem::EXAM_CHECKING;
        }

        if ($lastFinishedExamSession->passed === 0) {
            return ExamSystem::EXAM_FAILED;
        }

        if ($lastFinishedExamSession->passed === 1) {
            return ExamSystem::EXAM_PASSED;
        }
    }
}
