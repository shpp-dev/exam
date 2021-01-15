<?php


namespace App\Domains\Auth\Jobs;


use App\EverCookie;
use Lucid\Foundation\Job;

class UpdateEverCookieJob extends Job
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
            ->first();

        if ($everCookie) {
            $everCookie->token = $this->token;
        } else {
            $everCookie = new EverCookie();
            $everCookie->location = $this->clientLocation;
            $everCookie->client = $this->clientId;
            $everCookie->token = $this->token;
        }

        $everCookie->save();

        return $everCookie;
    }
}
