<?php


namespace App\Operations\Auth;


use App\Domains\Auth\Jobs\CheckEverCookieJob;
use App\Domains\User\Jobs\GetExamDataForUserJob;
use App\User;
use Lucid\Foundation\Operation;

class CheckLocationOperation extends Operation
{
    private $user;
    private $clientLocation;
    private $clientId;
    private $token;

    public function __construct(?User $user, ?string $clientLocation, ?string $clientId, ?string $token)
    {
        $this->user = $user;
        $this->clientLocation = $clientLocation;
        $this->clientId = $clientId;
        $this->token = $token;
    }

    public function handle()
    {
        if (!$this->user || !$this->clientLocation || !$this->clientId || !$this->token) {
            return false;
        }

        $locationIsCorrect = $this->checkLocationForUser();
        $clientIdentified = $this->clientIdentification();

        return $locationIsCorrect && $clientIdentified;
    }

    private function checkLocationForUser()
    {
        $examData = $this->run(GetExamDataForUserJob::class, [
            'user' => $this->user
        ]);

        return strcmp($this->clientLocation, $examData['location']) === 0;
    }

    private function clientIdentification()
    {
        return $this->run(CheckEverCookieJob::class, [
            'clientLocation' => $this->clientLocation,
            'clientId' => $this->clientId,
            'token' => $this->token
        ]);
    }
}
