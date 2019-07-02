<?php

namespace App\Http\Middleware;

use App\Domains\Auth\Auth;
use App\Domains\Helpers\Jobs\CheckAuthTokenInRedisJob;
use App\Domains\Helpers\Jobs\GetAuthTokenDataJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\SendHttpPostRequestJob;
use Closure;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\JobDispatcherTrait;
use Lucid\Foundation\MarshalTrait;

class CheckExamAccess
{
    use JobDispatcherTrait, MarshalTrait, DispatchesJobs;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::getAuthUser();

        $response = $this->run(SendHttpPostRequestJob::class, [
            'url' => config('ptp.accountBackUrl').'/user/exam/allowed',
            'data' => [
                'eco' => config('auth.eco'),
                'email' => $user->email
            ]
        ]);

        Log::info(json_encode($response));

        if (json_decode($response->getBody())->data->code != 200) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Denied',
                'code' => 403,
            ]);
        }

        return $next($request);
    }
}
