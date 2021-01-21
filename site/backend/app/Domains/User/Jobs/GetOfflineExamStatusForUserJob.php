<?php


namespace App\Domains\User\Jobs;


use App\Data\ExamSystem;
use App\Domains\User\Traits\CheckRetryExamAccessForUserTrait;
use App\User;
use Carbon\Carbon;
use Lucid\Foundation\Job;

class GetOfflineExamStatusForUserJob extends Job
{
    use CheckRetryExamAccessForUserTrait;

    /**
     * @var User|null
     */
    private $user;

    /**
     * @var bool
     */
    private $locationIdentified;

    public function __construct(?User $user, bool $locationIdentified)
    {
        $this->user = $user;
        $this->locationIdentified = $locationIdentified;
    }

    public function handle()
    {
        if ($this->user === null) {
            return ExamSystem::EXAM_NOT_AVAILABLE;
        }

        if ($this->user->exam_datetime === null && $this->checkRetryExamAccessForUser($this->user)) {
            return ExamSystem::EXAM_REGISTRATION_AVAILABLE;
        }

        if ($this->user->exam_datetime === null) {
            return ExamSystem::EXAM_FAILED;
        }

        $examDate = Carbon::parse($this->user->exam_datetime)->startOfDay();

        $today = Carbon::now()->startOfDay();
        $activeSession = $this->user->activeSession();
        $lastFinishedExamSession = $this->user->lastFinishedExamSession();
        $lastExamFinishDate = null;

        if ($lastFinishedExamSession) {
            $lastExamFinishDate = Carbon::parse($lastFinishedExamSession->created_at)->startOfDay();
        }

        if ($today < $examDate) {
            return ExamSystem::EXAM_PENDING;
        }

        if ($today->equalTo($examDate) && !$activeSession && $today->notEqualTo($lastExamFinishDate)) {
            return $this->locationIdentified ? ExamSystem::EXAM_AVAILABLE : ExamSystem::EXAM_TODAY;
        }

        if ($activeSession) {
            return ExamSystem::EXAM_PROGRESS;
        }

        if ($today > $examDate && $examDate->notEqualTo($lastExamFinishDate)) {
            return ExamSystem::EXAM_FAILED;
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
