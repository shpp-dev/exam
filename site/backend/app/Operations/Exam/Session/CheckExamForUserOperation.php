<?php


namespace App\Operations\Exam\Session;

use App\Domains\Exam\Session\Jobs\CheckExamSessionJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\SendHttpPostRequestToQueueJob;
use App\Domains\Mail\Jobs\SendMailToUsersJob;
use App\Domains\User\Jobs\ClearExamDataForUserJob;
use App\ExamSession;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Operation;

class CheckExamForUserOperation extends Operation
{
    /**
     * @var bool
     */
    private $passed;

    /**
     * @var int
     */
    private $sessionId;

    public function __construct(bool $passed, int $sessionId)
    {
        $this->passed = $passed;
        $this->sessionId = $sessionId;
    }

    public function handle()
    {
        $session = ExamSession::find($this->sessionId);

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

        $this->run(SendHttpPostRequestToQueueJob::class, [
            'url' => config('ptp.accountBackUrl').'/user/exam/add',
            'data' => [
                'eco' => config('auth.eco'),
                'email' => $email,
                'examResultsId' => $this->sessionId,
                'passed' => $this->passed,
                'examDateTs' => $session->finishedAt
            ]
        ]);

        $this->run(CheckExamSessionJob::class, [
            'session' => $session,
            'passed' => $this->passed
        ]);

        if (!$this->passed) {
            $this->run(ClearExamDataForUserJob::class, [
                'user' => $session->user
            ]);
        }

        $this->run(SendMailToUsersJob::class, [
            'emails' => [$email],
            'view' => $this->passed ? 'mails.exam-passed' : 'mails.exam-failed',
            'subject' => __('email_subjects.examChecked')
        ]);

        Log::info('Exam was checked for user '.$session->user->id.'. Passed: ' . $this->passed);
    }
}
