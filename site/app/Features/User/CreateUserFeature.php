<?php


namespace App\Features\User;


use App\Domains\Mail\Jobs\CreateUserJob;
use App\Domains\Mail\Jobs\SendMailToUsersJob;
use App\Domains\User\Jobs\ClearExamDataForUserJob;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;
use Lucid\Foundation\ServesFeaturesTrait;

class CreateUserFeature extends Feature
{
    use ServesFeaturesTrait;

    public function handle(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $users = $data['users'];
        $emails = [];

        foreach ($users as $user) {
            $user = $this->run(CreateUserJob::class, ['accountId' => $user['accountId'], 'email' => $user['email']]);
            $this->run(ClearExamDataForUserJob::class, ['user' => $user]);
            $emails[] = $user['email'];
        }

        $this->sendMailToUsers($emails);
    }
    
    private function sendMailToUsers(array $emails)
    {
        if (config('ptp.examOnline')) {
            $view = 'mails.invite-to-exam';
            $subject = __('email_subjects.inviteToExam');
        } else {
            $view = 'mails.invite-to-exam-registration';
            $subject = __('email_subjects.registrationToExam');
        }

        $this->run(SendMailToUsersJob::class, [
            'emails' => $emails,
            'view' => $view,
            'subject' => $subject
        ]);
    }
}
