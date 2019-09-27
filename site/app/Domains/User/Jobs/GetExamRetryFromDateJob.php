<?php


namespace App\Domains\User\Jobs;


use App\User;
use Carbon\Carbon;
use Lucid\Foundation\Job;

class GetExamRetryFromDateJob extends Job
{
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
        $lastFinishedExamSession = $this->user->lastFinishedExamSession();
        $examDate = $lastFinishedExamSession ? $lastFinishedExamSession->created_at : $this->user->exam_datetime;

        return Carbon::parse($examDate)
            ->addDays(config('ptp.retryTestingAfterDays'))
            ->toDateString();
    }
}
