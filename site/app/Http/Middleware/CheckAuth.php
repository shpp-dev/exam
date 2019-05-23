<?php

namespace App\Http\Middleware;

use App\Domains\Auth\Auth;
use App\Domains\Helpers\Jobs\CheckAuthTokenInRedisJob;
use App\Domains\Helpers\Jobs\GetAuthTokenDataJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\User;
use Closure;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\JobDispatcherTrait;
use Lucid\Foundation\MarshalTrait;

class CheckAuth
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
        // todo uncommented for production
//        if (!$authToken = $request->cookie('AT')) {
//            return $this->run(RespondWithJsonErrorJob::class, [
//                'message' => 'Non authorized',
//                'code' => 401,
//                'redirectTo' => 'accountF'
//            ]);
//        }
//
//        $authTokenData = $this->run(GetAuthTokenDataJob::class, ['authToken' => $authToken]);
//        if (isset($authTokenData['error'])) {
//            return $this->run(RespondWithJsonErrorJob::class, [
//                'message' => 'Non authorized',
//                'code' => 401,
//                'redirectTo' => 'accountF'
//            ]);
//        }

//        // check it in redis blacklist
//        $white = $this->run(CheckAuthTokenInRedisJob::class, [
//            'authToken' => $authToken,
//            'authTokenData' => $authTokenData['data']
//        ]);
//
//        if (!$white) {
//            return $this->run(RespondWithJsonErrorJob::class, [
//                'message' => 'Token not active',
//                'code' => 403,
//                'redirectTo' => 'accountF'
//            ]);
//        }
//
//        $user = Auth::authorizeByEmail($authTokenData['data']->userEmail);
//        if (!$user) {
//            return $this->run(RespondWithJsonErrorJob::class, [
//                'message' => 'It looks like we have not invite you yet',
//                'code' => 407,
//                'redirectTo' => 'accountF'
//            ]);
//        }


        // todo delete for production
        session_start();

        if (!isset($_SESSION['email'])) {
            $lastUser = User::all()->last();
            $email = $lastUser ? 'user' . ($lastUser->id + 1) : 'user1';

            $newUser = new User(['email' => $email]);
            $newUser->save();
            $_SESSION['email'] = $email;
        }

        Auth::authorizeByEmail($_SESSION['email']);

        return $next($request);
    }
}
