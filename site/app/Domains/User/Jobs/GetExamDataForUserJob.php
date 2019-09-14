<?php


namespace App\Domains\User\Jobs;


use App\User;
use Carbon\Carbon;
use Lucid\Foundation\Job;

class GetExamDataForUserJob extends Job
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
        return [
            'datetime' => $this->user->exam_datetime ? Carbon::parse($this->user->exam_datetime) : null,
            'location' => $this->user->exam_location
        ];
    }
}
