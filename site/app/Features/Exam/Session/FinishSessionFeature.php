<?php

namespace App\Features\Exam\Session;

use App\Domains\Auth\Auth;
use App\Domains\Exam\Session\Jobs\FinishSessionJob;
use App\Domains\Http\Jobs\SendHttpPostRequestJob;
use App\Domains\Mail\Jobs\SendMailToUserJob;
use App\ExamSession;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;

class FinishSessionFeature extends Feature
{
    private $session;

    public function __construct(ExamSession $session = null)
    {
        $this->session = $session;
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

        $this->run(SendMailToUserJob::class, [
            'email' => $email,
            'view' => 'mails.exam-completed',
            'subject' => 'Экзамен завершен' // todo use local
        ]);

        Log::info('Exam session was finished for user '. $this->session->user->id);
    }
}
