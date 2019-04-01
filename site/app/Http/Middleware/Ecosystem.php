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
        $data = json_decode($request->getContent(), true);
        if (!$data['eco'] || strcmp($data['eco'], config('auth.eco')) != 0) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Denied',
                'code' => 403
            ]);
        }

        return $next($request);
    }
}
