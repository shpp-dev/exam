<?php


namespace App\Domains\User\Traits;


use App\User;
use Carbon\Carbon;

trait CheckRetryExamAccessForUserTrait
{
    public function checkRetryExamAccessForUser(User $user)
    {
        $lastFinishedExam = $user->lastFinishedExamSession();

        if ($lastFinishedExam && Carbon::now()->diffInDays(Carbon::parse($lastFinishedExam->finished_at)) < config('ptp.retryTestingAfterDays')) {
            return false;
        }

        return true;
    }
}
