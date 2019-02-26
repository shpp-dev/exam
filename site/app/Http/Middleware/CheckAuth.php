<?php

namespace App\Http\Middleware;

use App\Domains\Auth\Auth;
use App\Domains\Helpers\Jobs\CheckAuthTokenInRedisJob;
use App\Domains\Helpers\Jobs\GetAuthTokenDataJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use Closure;
use Lucid\Foundation\JobDispatcherTrait;

class CheckAuth
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
        if (!$authToken = $request->cookie('AT')) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Non authorized',
                'code' => 401,
                'redirectTo' => 'accountF'
            ]);
        }

        $authTokenData = $this->run(GetAuthTokenDataJob::class, ['authToken' => $authToken]);
        if (isset($authTokenData['error'])) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Non authorized',
                'code' => 401,
                'redirectTo' => 'accountF'
            ]);
        }

        // check it in redis blacklist
        $white = $this->run(CheckAuthTokenInRedisJob::class, [
            'authToken' => $authToken,
            'authTokenData' => $authTokenData['data']]);

        if (!$white) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Token not active',
                'code' => 403,
                'redirectTo' => 'accountF'
            ]);
        }

        Auth::authorizeByEmail($authTokenData['data']->userEmail);

        return $next($request);
    }
}
