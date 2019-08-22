<?php


namespace App\Domains\Auth\Jobs;


use App\EverCookie;
use Lucid\Foundation\Job;

class RemoveEverCookieJob extends Job
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
        return EverCookie::where('cookie', $this->clientIdentifier)->delete();
    }
}
