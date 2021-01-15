<?php


namespace App\Domains\User\Jobs;


use App\User;
use Lucid\Foundation\Job;

class GetUserByEmailJob extends Job
{
    /**
     * @var string
     */
    private $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function handle()
    {
        return User::where('email', $this->email)->first();
    }
}
