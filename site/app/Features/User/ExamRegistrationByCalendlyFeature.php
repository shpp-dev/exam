<?php


namespace App\Features\User;


use App\Domains\Mail\Jobs\SendMailToAdminsJob;
use App\Domains\Mail\Jobs\SendMailToUsersJob;
use App\Domains\User\Jobs\ClearExamDataForUserJob;
use App\Domains\User\Jobs\GetExamDataForUserJob;
use App\Domains\User\Jobs\GetUserByEmailJob;
use App\Domains\User\Jobs\SetExamDataForUserJob;
use App\Domains\User\Traits\CheckRetryExamAccessForUserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;

class ExamRegistrationByCalendlyFeature extends Feature
{
    use CheckRetryExamAccessForUserTrait;

    public function handle(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        Log::info(json_encode($data));

        $inviteeEmail = $data['payload']['invitee']['email'];
        $name = $data['payload']['invitee']['name'];
        $examDatetime = $data['payload']['event']['start_time'];
        $location = $data['payload']['event']['location'];
        $canceled = $data['payload']['event']['canceled'];

        // todo check event_type

        $user = $this->run(GetUserByEmailJob::class, ['email' => $inviteeEmail]);

        if (!$user || !$this->checkRetryExamAccessForUser($user)) {
            $this->sendMailsAboutDeclineRegistration($inviteeEmail, $examDatetime, $name);
            return;
        }

        if ($canceled) {
            $this->run(ClearExamDataForUserJob::class, [
                'user' => $user
            ]);
        } else {
            $oldExamData = $this->run(GetExamDataForUserJob::class, ['user' => $user]);

            if ($oldExamData['datetime']) {
                $this->sendMailAboutReRegistration($inviteeEmail, $examDatetime, $location);
            }

            $this->run(SetExamDataForUserJob::class, [
                'user' => $user,
                'datetime' => $examDatetime,
                'location' => $location
            ]);
        }
    }

    private function sendMailsAboutDeclineRegistration(string $email, string $datetime, string $name)
    {
        $this->run(SendMailToAdminsJob::class, [
            'view' => 'mails.uninvited-user',
            'data' => ['email' => $email, 'datetime' => $datetime],
            'subject' => __('email_subjects.uninvitedUserForExam')
        ]);

        $this->run(SendMailToUsersJob::class, [
            'view' => 'mails.decline-registration-on-exam',
            'subject' => __('email_subjects.declineRegistrationOnExam'),
            'data' => ['name' => $name],
            'emails' => [$email]
        ]);
    }

    private function sendMailAboutReRegistration(string $email, string $datetime, string $location)
    {
        $this->run(SendMailToAdminsJob::class, [
            'view' => 'mails.re-registration-on-exam',
            'subject' => __('email_subjects.reRegistrationOnExam'),
            'data' => [
                'email' => $email,
                'datetime' => $datetime,
                'location' => $location
            ]
        ]);
    }
}
