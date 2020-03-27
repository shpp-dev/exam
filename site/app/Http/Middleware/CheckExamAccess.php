<?php

namespace App\Http\Middleware;

use App\Domains\Auth\Auth;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\SendHttpPostRequestJob;
use App\Domains\User\Traits\CheckRetryExamAccessForUserTrait;
use Closure;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Lucid\Foundation\JobDispatcherTrait;
use Lucid\Foundation\MarshalTrait;

class CheckExamAccess
{
    use JobDispatcherTrait, MarshalTrait, DispatchesJobs, CheckRetryExamAccessForUserTrait;

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::getAuthUser();
        $lastFinishedExamSession = $user->lastFinishedExamSession();

        if ($lastFinishedExamSession && $lastFinishedExamSession->passed) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Denied',
                'code' => 403,
            ]);
        }

        $response = $this->run(SendHttpPostRequestJob::class, [
            'url' => config('ptp.accountBackUrl').'/user/exam/allowed',
            'data' => [
                'eco' => config('auth.eco'),
                'email' => $user->email
            ]
        ]);

        if (json_decode($response->getBody())->data->code != 200 || !$this->checkRetryExamAccessForUser($user)) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Denied',
                'code' => 403,
            ]);
        }

        return $next($request);
    }
}
