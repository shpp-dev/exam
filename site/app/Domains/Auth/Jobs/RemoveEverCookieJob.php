<?php


namespace App\Domains\Auth\Jobs;


use App\EverCookie;
use Lucid\Foundation\Job;

class RemoveEverCookieJob extends Job
{
    /**
     * @var string
     */
    private $clientId;

    public function __construct(string $clientId)
    {
        $this->clientId = $clientId;
    }

    public function handle()
    {
        return EverCookie::where('cookie', $this->clientId)->delete();
    }
}
