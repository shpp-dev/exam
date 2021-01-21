<?php


namespace App\Features\User;


use App\Domains\Mail\Jobs\SendMailToUsersJob;
use App\Domains\User\Jobs\GetUserForExamRetryingJob;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;

class RetryExamNotificationFeature extends Feature
{
    public function handle()
    {
        $usersForRetrying = $this->run(GetUserForExamRetryingJob::class);
        $emails = [];

        foreach ($usersForRetrying as $user) {
            $emails[] = $user->email;
        }

        if ($emails) {
            $this->run(SendMailToUsersJob::class, [
                'emails' => $emails,
                'view' => 'mails.retry-exam-available',
                'subject' => __('email_subjects.retryExamAvailable')
            ]);

            Log::info('Send mails about exam retrying for users: ' . implode(', ', $emails));
        }
    }
}
