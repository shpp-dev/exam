<?php


namespace App\Domains\User\Jobs;


use App\User;
use Lucid\Foundation\Job;

class SetExamDataForUserJob extends Job
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $datetime;

    /**
     * @var string
     */
    private $location;

    public function __construct(User $user, string $datetime, string $location)
    {
        $this->user = $user;
        $this->datetime = $datetime;
        $this->location = $location;
    }

    public function handle()
    {
        $this->user->exam_location = $this->location;
        $this->user->exam_datetime = $this->datetime;

        $this->user->save();
    }
}
