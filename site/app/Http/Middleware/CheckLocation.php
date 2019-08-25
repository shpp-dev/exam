<?php

namespace App\Http\Middleware;

use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\User\Jobs\GetExamDataForUserJob;
use Closure;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Lucid\Foundation\JobDispatcherTrait;
use Lucid\Foundation\MarshalTrait;

class CheckLocation
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
        $clientLocation = $request->cookie('clientLocation');

        $examData = $this->run(GetExamDataForUserJob::class, [
            'user' => Auth::getAuthUser()
        ]);

        if (!$clientLocation || strcmp($clientLocation, $examData['location']) !== 0) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => ExamSystem::CLIENT_NOT_IDENTIFIED,
                'code' => 423
            ]);
        }

        return $next($request);
    }
}
