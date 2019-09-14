<?php


namespace App\Operations\Auth;


use App\Domains\Auth\Jobs\CheckEverCookieJob;
use App\Domains\User\Jobs\GetExamDataForUserJob;
use App\User;
use Carbon\Carbon;
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

        $examData = $this->run(GetExamDataForUserJob::class, [
            'user' => $this->user
        ]);

        if (!$this->checkExamTodayForUser($examData['datetime'])) {
            return false;
        }

        if (!$this->checkLocationForUser($examData['location'])) {
            return false;
        }

        if (!$this->checkClientIdentification()) {
            return false;
        }

        return true;
    }

    private function checkLocationForUser(?string $location)
    {
        return strcmp($this->clientLocation, $location) === 0;
    }

    private function checkExamTodayForUser(?Carbon $examDate)
    {
        return $examDate && Carbon::now()->startOfDay()->equalTo($examDate->startOfDay());
    }

    private function checkClientIdentification()
    {
        return $this->run(CheckEverCookieJob::class, [
            'clientLocation' => $this->clientLocation,
            'clientId' => $this->clientId,
            'token' => $this->token
        ]);
    }
}
