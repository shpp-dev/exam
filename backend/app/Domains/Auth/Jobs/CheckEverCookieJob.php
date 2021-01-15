<?php


namespace App\Domains\Auth\Jobs;


use App\EverCookie;
use Lucid\Foundation\Job;

class CheckEverCookieJob extends Job
{
    /**
     * @var string
     */
    private $clientLocation;

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $token;

    public function __construct(string $clientLocation, string $clientId, string $token)
    {
        $this->clientLocation = $clientLocation;
        $this->clientId = $clientId;
        $this->token = $token;
    }

    public function handle()
    {
        $everCookie = EverCookie::where('location', $this->clientLocation)
            ->where('client', $this->clientId)
            ->where('token', $this->token)
            ->first();

        return $everCookie !== null;
    }
}
