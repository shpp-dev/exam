<?php


namespace App\Domains\Exam\Session\Jobs;


use App\User;
use Lucid\Foundation\Job;

class SaveZeroStatusForUserJob extends Job
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var int
     */
    private $zeroStatus;

    public function __construct(User $user, int $zeroStatus)
    {
        $this->user = $user;
        $this->zeroStatus = $zeroStatus;
    }

    public function handle()
    {
        $lastFinishedExamSession = $this->user->lastFinishedExamSession();
        $lastFinishedExamSession->zero_status = $this->zeroStatus;
        $lastFinishedExamSession->save();
    }
}
