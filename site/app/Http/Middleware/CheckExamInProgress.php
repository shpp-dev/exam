<?php

namespace App\Http\Middleware;

use App\Domains\Auth\Auth;
use App\Domains\Helpers\Jobs\CheckAuthTokenInRedisJob;
use App\Domains\Helpers\Jobs\GetAuthTokenDataJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\SendHttpPostRequestJob;
use Closure;
use Lucid\Foundation\JobDispatcherTrait;

class CheckExamInProgress
{
    use JobDispatcherTrait;

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
        if ($activeSession = $user->activeSession()) {
            return $next($request);
        } else {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'You are not on exam now',
                'code' => 418,
            ]);
        }
    }
}
