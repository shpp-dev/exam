<?php

namespace App\Domains\Exam\Session\Jobs;


use App\User;
use Lucid\Foundation\Job;

class SaveFeedbackAboutExamJob extends Job
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $feedback;

    public function __construct(User $user, string $feedback)
    {
        $this->user = $user;
        $this->feedback = $feedback;
    }

    public function handle()
    {
        $this->user->lastFinishedExamSession()->feedback = $this->feedback;
        $this->user->save();
    }
}
