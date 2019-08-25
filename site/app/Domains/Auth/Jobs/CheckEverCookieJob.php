<?php


namespace App\Domains\Auth\Jobs;


use App\EverCookie;
use Lucid\Foundation\Job;

class CheckEverCookieJob extends Job
{
    /**
     * @var string|null
     */
    private $clientId;

    private $identified = false;

    public function __construct(?string $clientId)
    {
        $this->clientId = $clientId;
    }

    public function handle()
    {
        if ($this->clientId) {
            $everCookie = EverCookie::where('cookie', $this->clientId)->first();

            $this->identified = $everCookie !== null;
        }

        return $this->identified;
    }
}
