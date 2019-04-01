<?php

namespace App\Http\Middleware;

use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use Closure;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Lucid\Foundation\JobDispatcherTrait;
use Lucid\Foundation\MarshalTrait;

class Ecosystem
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
        if (!$request->eco || $request->eco != config('auth.eco')) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Denied',
                'code' => 403
            ]);
        }

        return $next($request);
    }
}
