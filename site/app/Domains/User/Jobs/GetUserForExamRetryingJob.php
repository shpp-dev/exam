<?php


namespace App\Domains\User\Jobs;


use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Job;

class GetUserForExamRetryingJob extends Job
{
    public function handle()
    {
        $users = User::all();
        $usersForExamRetrying = [];

        /* @var User $user */
        foreach ($users as $user) {
            $lastFailedExam = $user->lastFailedExamSession();

            if (!$lastFailedExam) {
                continue;
            }

            $failedExamDate = Carbon::parse($lastFailedExam->finished_at);

            if (Carbon::now()->startOfDay()
                ->equalTo($failedExamDate->startOfDay()->addDays(config('ptp.retryTestingAfterDays')))) {

                $usersForExamRetrying[] = $user;
            }
        }

        return $usersForExamRetrying;
    }
}
