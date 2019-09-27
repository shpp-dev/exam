<?php


namespace App\Domains\User\Jobs;


use App\User;
use Carbon\Carbon;
use Lucid\Foundation\Job;

class GetUsersWhoMissedExamAndAllowedToRegisterJob extends Job
{
    public function handle()
    {
        $usersWithExamDate = User::whereNotNull('exam_datetime')->get();
        $usersWhoMissedExamAndAllowedToRegister = [];

        /* @var User $user */
        foreach ($usersWithExamDate as $user) {
            $examDate = Carbon::parse($user->exam_datetime);
            $session = $user->sessionForSpecificDate($examDate);

            if (!$session && Carbon::now()->greaterThanOrEqualTo($examDate->addDays(config('ptp.retryTestingAfterDays')))) {
                $usersWhoMissedExamAndAllowedToRegister[] = $user;
            }
        }

        return $usersWhoMissedExamAndAllowedToRegister;
    }
}
