<?php
namespace App\Domains\Mail\Jobs;

use App\User;
use Carbon\Carbon;
use Lucid\Foundation\Job;

/**
 * Class CreateUserJob
 * @package App\Domains\Mail\Jobs
 */
class CreateUserJob extends Job
{
    /**
     * @var int
     */
    private $accountId;

    /**
     * @var string
     */
    private $email;

    /**
     * SendFinishExamMailToStudentJob constructor.
     * @param int $accountId
     * @param string $email
     */
    public function __construct(int $accountId, string $email)
    {
        $this->accountId = $accountId;
        $this->email = $email;
    }

    public function handle()
    {
        if (!$user = User::where('email', $this->email)->first()) {
            $user = new User();
            $user->account_id = $this->accountId;
            $user->email = $this->email;
            $user->exam_datetime = null;
            $user->exam_location = null;
            $user->check_location = true;
            $user->save();
        }

        return $user;
    }
}
