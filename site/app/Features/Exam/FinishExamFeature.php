<?php

namespace App\Features\Exam;

use App\Domains\Auth\Auth;
use App\Domains\Exam\Jobs\FinishExamSessionsJob;
use App\Domains\Mail\Jobs\SendFinishExamMailToStudentJob;
use App\ExamSession;
use Illuminate\Support\Collection;
use Lucid\Foundation\Feature;

class FinishExamFeature extends Feature
{
    private $examSessions;

    public function __construct(Collection $examSessions = null)
    {
        $this->examSessions = $examSessions;
    }

    public function handle()
    {
        $emails = [];

        if ($this->examSessions) {
            $sessions = $this->examSessions;

            /* @var ExamSession $examSession */
            foreach ($this->examSessions as $examSession) {
                $emails[] = $examSession->user->email;
            }
        } else {
            $user = Auth::getAuthUser();
            $sessions = collect()->push($user->activeSession());
            $emails[] = $user->email;
        }

        $this->run(FinishExamSessionsJob::class, ['sessions' => $sessions]);
        $this->run(SendFinishExamMailToStudentJob::class, ['emails' => $emails]);
    }
}
