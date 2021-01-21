<?php

namespace App\Http\Middleware;

use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\Domains\Auth\Jobs\CheckEverCookieJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\User\Jobs\GetExamDataForUserJob;
use App\Operations\Auth\CheckLocationOperation;
use Closure;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Lucid\Foundation\JobDispatcherTrait;
use Lucid\Foundation\MarshalTrait;
use Lucid\Foundation\ServesFeaturesTrait;

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
        if (config('ptp.examOnline') || config('app.env') === 'development') {
            return $next($request);
        }

        $clientForExam = json_decode($request->cookie('clientForExam'), true);

        $locationIdentified = $this->run(CheckLocationOperation::class, [
            'user' => Auth::getAuthUser(),
            'clientLocation' => $clientForExam['clientLocation'] ?? null,
            'clientId' => $clientForExam['clientId'] ?? null,
            'token' => $clientForExam['token'] ?? null
        ]);

        if (!$locationIdentified) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => ExamSystem::CLIENT_NOT_IDENTIFIED,
                'code' => 423
            ]);
        }

        return $next($request);
    }
}
