<?php


namespace App\Domains\User\Jobs;


use App\User;
use Lucid\Foundation\Job;

class ClearExamDataForUserJob extends Job
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
        $this->user->exam_datetime = null;
        $this->user->exam_location = null;
        $this->user->save();
    }
}
