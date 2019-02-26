<?php

namespace App\Http\Middleware;

use App\Domains\Auth\Auth;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use Closure;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Lucid\Foundation\JobDispatcherTrait;
use Lucid\Foundation\MarshalTrait;

class Admin
{
    use MarshalTrait;
    use DispatchesJobs;
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
        if (!Auth::getAuthUser()->admin) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Denied',
                'code' => 405
            ]);
        }
        return $next($request);
    }
}
