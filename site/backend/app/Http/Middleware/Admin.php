<?php

namespace App\Http\Middleware;

use App\Domains\Auth\Auth;
use App\Domains\Helpers\Jobs\GetAuthTokenDataJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use Closure;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Lucid\Foundation\JobDispatcherTrait;
use Lucid\Foundation\MarshalTrait;

class Admin
{
    use MarshalTrait, DispatchesJobs, JobDispatcherTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('app.env') === 'development') {
            return $next($request);
        }

        if (!$authToken = $request->cookie('AT')) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Non authorized',
                'code' => 401
            ]);
        }

        $authTokenData = $this->run(GetAuthTokenDataJob::class, ['authToken' => $authToken]);
        if (isset($authTokenData['error'])) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Non authorized',
                'code' => 401
            ]);
        }

        if (!$authTokenData['data']->admin) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Denied',
                'code' => 403
            ]);
        }

        return $next($request);
    }
}
