<?php


namespace App\Domains\Exam\Session\Jobs;


use App\User;
use Lucid\Foundation\Job;

class GetFeedbackAboutLastExamJob extends Job
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
        $lastFinishedSession = $this->user->lastFinishedExamSession();

        return $lastFinishedSession->feedback;
    }
}
