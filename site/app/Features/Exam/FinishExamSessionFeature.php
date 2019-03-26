<?php

namespace App\Features\Exam;

use App\Domains\Auth\Auth;
use App\Domains\ExamSession\Jobs\FinishExamSessionsJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\SendHttpPostRequestJob;
use App\Domains\Mail\Jobs\SendFinishExamMailToStudentJob;
use App\ExamSession;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;

class FinishExamSessionFeature extends Feature
{
    private $examSessions;

    public function __construct(Collection $examSessions = null)
    {
        $this->examSessions = $examSessions;
    }

    public function handle()
    {
        $emails = [];

        try {
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

            DB::beginTransaction();
            $this->run(FinishExamSessionsJob::class, ['sessions' => $sessions]);

            foreach ($emails as $email) {
                $this->run(SendHttpPostRequestJob::class, [
                    'url' => config('ptp.accountBackUrl').'/user/exam/finish',
                    'data' => [
                        'eco' => config('auth.eco'),
                        'email' => $email,
                    ]
                ]);
            }

            $this->run(SendFinishExamMailToStudentJob::class, ['emails' => $emails]);
            DB::commit();
            Log::info('Exam was finished for user '. implode(', ', $emails));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Internal server error',
                'code' => 500
            ]);
        }
    }
}
