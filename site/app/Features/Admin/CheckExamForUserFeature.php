<?php

namespace App\Features\Exam;

use App\Domains\Auth\Auth;
use App\Domains\Exam\Jobs\CheckExamSessionJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\SendHttpPostRequestJob;
use App\ExamSession;
use Illuminate\Http\Request;
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

        // todo send request to account
        $this->run(SendHttpPostRequestJob::class, [
            'url' => config('ptp.accountBackUrl').'/user/exam/add',
            'data' => [
                'email' => $session->user->email,
                'examResultsId' => $sessionId,
                'passed' => $passed
            ]
        ]);

        $this->run(CheckExamSessionJob::class, [
            'session' => $session,
            'passed' => $passed
        ]);
    }
}
