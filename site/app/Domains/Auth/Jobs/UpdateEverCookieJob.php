<?php


namespace App\Domains\Auth\Jobs;


use App\EverCookie;
use Lucid\Foundation\Job;

class UpdateEverCookieJob extends Job
{
    /**
     * @var string
     */
    private $newClientId;

    /**
     * @var string|null
     */
    private $oldClientId;

    public function __construct(string $newClientId, ?string $oldClientId)
    {
        $this->newClientId = $newClientId;
        $this->oldClientId = $oldClientId;
    }

    public function handle()
    {
        return EverCookie::updateOrCreate(
            ['cookie' => $this->oldClientId],
            ['cookie' => $this->newClientId]
        );
    }
}
