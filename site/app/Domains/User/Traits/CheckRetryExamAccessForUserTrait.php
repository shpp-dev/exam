<?php


namespace App\Domains\User\Traits;


use App\User;
use Carbon\Carbon;

trait CheckRetryExamAccessForUserTrait
{
    public function checkRetryExamAccessForUser(User $user)
    {
        $lastFailedExam = $user->lastFailedExamSession();

        if ($lastFailedExam && Carbon::now()->diffInDays(Carbon::parse($lastFailedExam->finished_at)) < config('ptp.retryTestingAfterDays')) {
            return false;
        }

        return true;
    }
}
