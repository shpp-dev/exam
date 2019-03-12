<?php

namespace App\Features\Exam;

use App\Domains\Auth\Auth;
use App\Domains\Exam\Jobs\CheckExamSessionJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\SendHttpPostRequestJob;
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
        if ($session->finishedAt) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Exam has been already checked',
                'code' => 405
            ]);
        }

        $this->run(SendHttpPostRequestJob::class, [
            'url' => config('ptp.accountBackUrl').'/user/exam/add',
            'data' => [
                'eco' => config('auth.eco'),
                'email' => $session->user->email,
                'examResultsId' => $sessionId,
                'passed' => $passed,
                'examDateTs' => $session->finishedAt
            ]
        ]);

        $this->run(CheckExamSessionJob::class, [
            'session' => $session,
            'passed' => $passed
        ]);

        Log::info('Exam was checked for user '.$session->user->id.'. Passed: '.$passed);
    }
}
