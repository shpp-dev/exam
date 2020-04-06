<?php

namespace App\Features\Exam\Session;

use App\Domains\Auth\Auth;
use App\Domains\Exam\Session\Jobs\FinishSessionJob;
use App\Domains\Http\Jobs\SendHttpPostRequestJob;
use App\Domains\Mail\Jobs\SendMailToAdminsJob;
use App\Domains\Mail\Jobs\SendMailToUsersJob;
use App\ExamSession;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;

class FinishSessionFeature extends Feature
{
    private $session;
    private $forced;

    public function __construct(ExamSession $session = null, bool $forced = false)
    {
        $this->session = $session;
        $this->forced = $forced;
    }

    public function handle()
    {
        if (!$this->session) {
            $user = Auth::getAuthUser();
            $this->session = $user->activeSession();
        }

        $email = $this->session->user->email;

        $this->run(SendHttpPostRequestJob::class, [
            'url' => config('ptp.accountBackUrl').'/user/exam/finish',
            'data' => [
                'eco' => config('auth.eco'),
                'email' => $email,
            ]
        ]);

        $this->run(FinishSessionJob::class, [
            'session' => $this->session
        ]);

        $this->run(SendMailToUsersJob::class, [
            'emails' => [$email],
            'view' => $this->forced ? 'mail.exam-completed-forced' : 'mails.exam-completed',
            'subject' => __('email_subjects.examFinished')
        ]);

        $this->run(SendMailToAdminsJob::class, [
            'subject' => $this->forced ? __('email_subjects.forcedExamFinish') : __('email_subjects.examFinishedForAdmin'),
            'view' => $this->forced ? 'mails.admin.forced-exam-finish' : 'mails.admin.exam-finished',
            'data' => ['email' => $email]
        ]);

        Log::info('Exam session was finished for user '. $this->session->user->id);
    }
}
