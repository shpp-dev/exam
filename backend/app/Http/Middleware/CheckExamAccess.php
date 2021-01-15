<?php

namespace App\Http\Middleware;

use App\Domains\Auth\Auth;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\SendHttpPostRequestJob;
use App\Domains\User\Traits\CheckRetryExamAccessForUserTrait;
use Carbon\Carbon;
use Closure;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        if (json_decode($response->getBody())->data->code != 200
            || !$this->checkRetryExamAccessForUser($user)
            || $this->ptpStartToday()) {

            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Denied',
                'code' => 403,
            ]);
        }

        return $next($request);
    }

    private function ptpStartToday()
    {
        try {
            $response = $this->run(SendHttpPostRequestJob::class, [
                'url' => config('ptp.ptpStartDatesUrl'),
                'data' => [
                    'eco' => config('auth.eco'),
                ]
            ]);

            $startDates = json_decode($response->getBody(), true)['data']['startDates'] ?? [];

            if (in_array(Carbon::now()->toDateString(), $startDates)) {
                return true;
            }

            return false;
        } catch (\Exception $exception) {
            Log::error($exception);

            return false;
        }
    }
}
