<?php

namespace App\Domains\Helpers\Jobs;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Lucid\Foundation\Job;
use Predis\Connection\ConnectionException;

class CheckAuthTokenInRedisJob extends Job
{
    /**
     * @var string
     */
    private $authToken;

    /**
     * @var array
     */
    private $authTokenData;

    /**
     * CheckAuthTokenInRedisJob constructor.
     * @param string $authToken
     * @param array $authTokenData
     */
    public function __construct(string $authToken, array $authTokenData)
    {
        $this->authToken = $authToken;
        $this->authTokenData = $authTokenData;
    }

    /**
     * @return bool
     */
    public function handle()
    {
        try {
            $white = Redis::get($this->authToken) ? false : true;
        } catch (ConnectionException $e) {
            Log::error('Can not check in redis login data for user:'.$this->authTokenData->userEmail
                .' for session:'.$this->authTokenData->sessionId
                .' with token:'.$this->authToken.
                ' due to redis ConnectionException');
            $white = true;
        }
        return $white;
    }

}
