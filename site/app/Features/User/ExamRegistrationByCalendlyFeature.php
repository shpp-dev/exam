<?php


namespace App\Features\User;


use App\Domains\Mail\Jobs\SendMailToAdminsJob;
use App\Domains\Mail\Jobs\SendMailToUsersJob;
use App\Domains\User\Jobs\GetExamDataForUserJob;
use App\Domains\User\Jobs\GetUserByEmailJob;
use App\Domains\User\Jobs\SetExamDataForUserJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;

class ExamRegistrationByCalendlyFeature extends Feature
{
    public function handle(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        Log::info('Calendly test request: ' . json_encode($data));

//        $inviteeEmail = $data['payload']['invitee']['email'];
//        $name = $data['payload']['invitee']['name'];
//        $examDatetime = $data['payload']['event']['start_time'];
//        $location = $data['payload']['event']['location'];
//
//        $user = $this->run(GetUserByEmailJob::class, ['email' => $inviteeEmail]);
//
//        if (!$user) {
//            $this->sendMailsAboutDeclineRegistration($inviteeEmail, $examDatetime, $name);
//            return;
//        }
//
//        $oldExamData = $this->run(GetExamDataForUserJob::class, ['user' => $user]);
//
//        if ($oldExamData['datetime']) {
//            $this->sendMailAboutReRegistration($inviteeEmail, $examDatetime, $location);
//        }
//
//        $this->run(SetExamDataForUserJob::class, [
//            'user' => $user,
//            'datetime' => $examDatetime,
//            'location' => $location
//        ]);
    }

    private function sendMailsAboutDeclineRegistration(string $email, string $datetime, string $name)
    {
        $this->run(SendMailToAdminsJob::class, [
            'view' => 'mails.uninvited-user',
            'data' => ['email' => $email, 'datetime' => $datetime],
            'subject' => 'Неприглашенный пользователь записался на экзамен' // todo use local
        ]);

        $this->run(SendMailToUsersJob::class, [
            'view' => 'mails.decline-registration-on-exam',
            'subject' => 'Отмена регистрации на экзамен', // todo use local
            'data' => ['name' => $name],
            'emails' => [$email]
        ]);
    }

    private function sendMailAboutReRegistration(string $email, string $datetime, string $location)
    {
        $this->run(SendMailToAdminsJob::class, [
            'view' => 'mails.re-registration-on-exam',
            'subject' => 'Повторная регистрация на экзамен', // todo user local
            'data' => [
                'email' => $email,
                'datetime' => $datetime,
                'location' => $location
            ]
        ]);
    }
}
