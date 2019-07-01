<?php

namespace App\Features\Exam\Session;

use App\Domains\Auth\Auth;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\SendHttpPostRequestJob;
use Lucid\Foundation\Feature;

class CheckExamAllowedStatusFeature extends Feature
{
    public function handle()
    {
        $user = Auth::getAuthUser();
        if ($activeSession = $user->activeSession()) {
            return $this->run(RespondWithJsonJob::class, [
               'content' => [
                   'status' => 'started',
                   'code' => 201
               ]
            ]);
        }

        $response = $this->run(SendHttpPostRequestJob::class, [
            'url' => config('ptp.accountBackUrl').'/user/exam/allowed',
            'data' => [
                'eco' => config('auth.eco'),
                'email' => $user->email
            ]
        ]);
        if (json_decode($response->getBody())->data->code == 200) {
            $message = [
                'status' => 'readyToStart',
                'code' => 200
            ];
        } else {
            $message = [
                'status' => 'denied',
                'code' => 407
            ];
        }
        return $this->run(RespondWithJsonJob::class, [
            'content' => $message
        ]);
    }
}
