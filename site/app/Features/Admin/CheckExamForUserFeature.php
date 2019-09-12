<?php

namespace App\Features\Exam;

use App\Domains\Exam\Session\Jobs\CheckExamSessionJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\SendHttpPostRequestJob;
use App\Domains\Mail\Jobs\SendMailToUsersJob;
use App\Domains\User\Jobs\ClearExamDataForUserJob;
use App\ExamSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;

class CheckExamForUserFeature extends Feature
{
    public function handle(Request $request)
    {
        $passed = $request->passed;
        $sessionId = $request->sessionId;

        $session = ExamSession::find($sessionId);

        if (!$session) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Exam session not found',
                'code' => 404
            ]);
        }

        if ($session->passed != null) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Exam has been already checked',
                'code' => 405
            ]);
        }

        $email = $session->user->email;

        $this->run(SendHttpPostRequestJob::class, [
            'url' => config('ptp.accountBackUrl').'/user/exam/add',
            'data' => [
                'eco' => config('auth.eco'),
                'email' => $email,
                'examResultsId' => $sessionId,
                'passed' => $passed,
                'examDateTs' => $session->finishedAt
            ]
        ]);

        $this->run(CheckExamSessionJob::class, [
            'session' => $session,
            'passed' => $passed
        ]);

        if (!$passed) {
            $this->run(ClearExamDataForUserJob::class, [
                'user' => $session->user
            ]);
        }

        $this->run(SendMailToUsersJob::class, [
            'emails' => [$email],
            'view' => $passed ? 'mails.exam-passed' : 'mails.exam-failed',
            'subject' => __('email_subjects.examChecked')
        ]);

        Log::info('Exam was checked for user '.$session->user->id.'. Passed: '.$passed);
    }
}
