<?php


namespace App\Domains\Auth\Jobs;


use App\EverCookie;
use Lucid\Foundation\Job;

class CheckEverCookieJob extends Job
{
    /**
     * @var string
     */
    private $clientIdentifier;

    public function __construct(string $clientIdentifier)
    {
        $this->clientIdentifier = $clientIdentifier;
    }

    public function handle()
    {
        $everCookie = EverCookie::where('cookie', $this->clientIdentifier)->first();

        return $everCookie !== null;
    }

}
