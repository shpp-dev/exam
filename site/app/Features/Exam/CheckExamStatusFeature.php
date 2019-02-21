<?php

namespace App\Features\Exam;

use App\Domains\Auth\Auth;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\SendHttpPostRequestJob;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class CheckExamStatusFeature extends Feature
{
    public function handle(Request $request)
    {
        $user = Auth::getAuthUser();
        if ($activeSession = $user->activeSession()) {
            return $this->run(RespondWithJsonJob::class, [
               'content' => [
                   'message' => 'In progress',
                   'code' => 201
               ]
            ]);
        }
        // todo check answer format
        $access = $this->run(SendHttpPostRequestJob::class, [
            'url' => config('ptp.accountBackUrl').'/user/exam/allowed',
            'data' => [
                'email' => $user->email
            ]
        ]);

        if ($access) {
            $message = [
                'message' => 'Ready to start',
                'code' => 200
            ];
        } else {
            $message = [
                'message' => 'Denied',
                'code' => 403
            ];
        }
        $this->run(RespondWithJsonJob::class, [
            'content' => $message
        ]);
    }
}
