<?php


namespace App\Domains\Auth\Jobs;


use App\EverCookie;
use Lucid\Foundation\Job;

class UpdateEverCookieJob extends Job
{
    /**
     * @var string
     */
    private $newClientIdentifier;

    /**
     * @var string|null
     */
    private $oldClientIdentifier;

    public function __construct(string $newClientIdentifier, ?string $oldClientIdentifier)
    {
        $this->newClientIdentifier = $newClientIdentifier;
        $this->oldClientIdentifier = $oldClientIdentifier;
    }

    public function handle()
    {
        return EverCookie::updateOrCreate(
            ['cookie' => $this->oldClientIdentifier],
            ['cookie' => $this->newClientIdentifier]
        );
    }
}
