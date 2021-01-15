<?php


namespace App\Features\User;


use App\Domains\User\Jobs\ClearExamDataForUserJob;
use App\Domains\User\Jobs\GetUsersWhoMissedExamAndAllowedToRegisterJob;
use Lucid\Foundation\Feature;

class ClearRegDataForUsersWhoMissedExamFeature extends Feature
{
    public function handle()
    {
        $usersWhoMissedExam = $this->run(GetUsersWhoMissedExamAndAllowedToRegisterJob::class);

        foreach ($usersWhoMissedExam as $user) {
            $this->run(ClearExamDataForUserJob::class, ['user' => $user]);
        }
    }
}
