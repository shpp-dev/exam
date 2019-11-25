<?php


namespace App\Features\User;


use App\Domains\Mail\Jobs\SendMailToAdminsJob;
use App\Domains\Mail\Jobs\SendMailToUsersJob;
use App\Domains\User\Jobs\ClearExamDataForUserJob;
use App\Domains\User\Jobs\GetExamDataForUserJob;
use App\Domains\User\Jobs\GetUserByEmailJob;
use App\Domains\User\Jobs\SetExamDataForUserJob;
use App\Domains\User\Traits\CheckRetryExamAccessForUserTrait;
use Carbon\Carbon;
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

        $examData = $this->run(GetExamDataForUserJob::class, ['user' => $user]);

        if ($canceled) {
            if (Carbon::createFromTimeString($examDatetime)->equalTo($examData['datetime'])) {
                $this->run(ClearExamDataForUserJob::class, [
                    'user' => $user
                ]);
            }
        } else {
            if ($examData['datetime']) {
                $this->sendMailAboutReRegistration($inviteeEmail, $location, $examDatetime, $examData['datetime']);
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

    private function sendMailAboutReRegistration(string $email, string $location, string $newExamDatetime, ?Carbon $oldExamDatetime)
    {
        $this->run(SendMailToAdminsJob::class, [
            'view' => 'mails.re-registration-on-exam',
            'subject' => __('email_subjects.reRegistrationOnExam'),
            'data' => [
                'email' => $email,
                'newDatetime' => Carbon::parse($newExamDatetime)->toDateTimeString(),
                'oldDatetime' => $oldExamDatetime ? $oldExamDatetime->toDateTimeString() : null,
                'location' => $location
            ]
        ]);
    }
}
