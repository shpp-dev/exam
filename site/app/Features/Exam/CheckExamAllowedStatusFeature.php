<?php

namespace App\Features\Exam;

use App\Domains\Auth\Auth;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\SendHttpPostRequestJob;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class CheckExamAllowedStatusFeature extends Feature
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
        $response = $this->run(SendHttpPostRequestJob::class, [
            'url' => config('ptp.accountBackUrl').'/user/exam/allowed',
            'data' => [
                'eco' => config('auth.eco'),
                'email' => $user->email
            ]
        ]);
        if (json_decode($response->getBody())->data->code == 200) {
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
        return $this->run(RespondWithJsonJob::class, [
            'content' => $message
        ]);
    }
}
