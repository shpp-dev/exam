<?php

namespace App\Features\Exam\Session;

use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;

class CheckExamStatusFeature extends Feature
{
    public function handle()
    {
        $user = Auth::getAuthUser();
        $status = $user->activeSession() ? ExamSystem::STARTED : ExamSystem::READY_TO_START;

        return $this->run(RespondWithJsonJob::class, [
            'content' => [
                'status' => $status
            ]
        ]);
    }
}
