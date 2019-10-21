<?php


namespace App\Domains\User\Jobs;


use App\User;
use Lucid\Foundation\Job;

class DisableCheckingLocationForUserJob extends Job
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $this->user->check_location = false;
        $this->user->save();
    }
}
