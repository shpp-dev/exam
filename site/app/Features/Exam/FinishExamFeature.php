<?php

namespace App\Features\Exam;

use App\Domains\Auth\Auth;
use App\Domains\Exam\Jobs\FinishExamSessionJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\SendHttpPostRequestJob;
use App\Domains\Mail\Jobs\SendFinishExamMailToStudentJob;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class FinishExamFeature extends Feature
{
    public function handle(Request $request)
    {
        $user = Auth::getAuthUser();
        $session = $user->activeSession();

        $this->run(FinishExamSessionJob::class, ['session' => $session]);
        $this->run(SendFinishExamMailToStudentJob::class, ['receiverEmail' => $user->email]);
    }
}
