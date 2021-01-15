<?php


namespace App\Domains\User\Jobs;


use App\Data\ExamSystem;
use App\Domains\User\Traits\CheckRetryExamAccessForUserTrait;
use App\User;
use Lucid\Foundation\Job;

class GetOnlineExamStatusForUserJob extends Job
{
    use CheckRetryExamAccessForUserTrait;

    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        if ($this->user === null) {
            return ExamSystem::EXAM_NOT_AVAILABLE;
        }

        if ($this->user->activeSession()) {
            return ExamSystem::EXAM_PROGRESS;
        }

        $lastFinishedExamSession = $this->user->lastFinishedExamSession();

        if ($lastFinishedExamSession) {
            if ($lastFinishedExamSession->passed === 0) {
                ExamSystem::EXAM_FAILED;
            }

            if ($lastFinishedExamSession->passed === null) {
                return ExamSystem::EXAM_CHECKING;
            }

            if ($lastFinishedExamSession->passed === 1) {
                return ExamSystem::EXAM_PASSED;
            }

            return $this->checkRetryExamAccessForUser($this->user)
                ? ExamSystem::EXAM_AVAILABLE
                : ExamSystem::EXAM_FAILED;
        }

        return ExamSystem::EXAM_AVAILABLE;
    }
}
