<?php

namespace App\Http\Middleware;

use App\Data\ExamSystem;
use App\Domains\Auth\Jobs\CheckEverCookieJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use Closure;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Log;
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
        Log::info(json_encode('Cookies: ' . $request->cookie()));
        Log::info($request->cookie('clientId'));

        $clientIdentified = $this->run(CheckEverCookieJob::class, [
            'clientId' => $request->cookie('clientId')
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
