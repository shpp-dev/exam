<?php

namespace App\Http\Middleware;

use App\Data\ExamSystem;
use App\Domains\Auth\Jobs\CheckEverCookieJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use Closure;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Lucid\Foundation\JobDispatcherTrait;
use Lucid\Foundation\MarshalTrait;

class ClientIdentification
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
        $clientIdentified = $this->run(CheckEverCookieJob::class, [
            'clientIdentifier' => $request->cookie('examClientIdentifier')
        ]);

        if (!$clientIdentified) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => ExamSystem::CLIENT_NOT_IDENTIFIED,
                'code' => 423
            ]);
        }

        return $next($request);
    }
}
