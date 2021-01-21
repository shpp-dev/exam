<?php


namespace App\Domains\Auth\Jobs;


use App\EverCookie;
use Lucid\Foundation\Job;

class RemoveEverCookieJob extends Job
{
    /**
     * @var string
     */
    private $clientLocation;

    /**
     * @var string
     */
    private $clientId;

    public function __construct(string $clientLocation, string $clientId)
    {
        $this->clientLocation = $clientLocation;
        $this->clientId = $clientId;
    }

    public function handle()
    {
        return EverCookie::where('location', $this->clientLocation)
            ->where('client', $this->clientId)
            ->delete();
    }
}
