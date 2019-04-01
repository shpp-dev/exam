<?php
namespace App\Domains\Mail\Jobs;

use App\User;
use Illuminate\Support\Facades\Mail;
use Lucid\Foundation\Job;

/**
 * Class CreateUserJob
 * @package App\Domains\Mail\Jobs
 */
class CreateUserJob extends Job
{
    /**
     * @var array
     */
    private $email;

    /**
     * SendFinishExamMailToStudentJob constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function handle()
    {
        if (!$user = User::where('email', $this->email)->first()) {
            $user = new User();
            $user->email = $this->email;
            $user->save();
        }
        return $user;
    }
}
