<?php

namespace App\Domains\Exam\Jobs;


use App\ExamSession;
use Carbon\Carbon;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Lucid\Foundation\Job;

class CreateExamSessionJob extends Job
{
    private $userId;
    private $startedAt;
    private $tasks;

    public function __construct(int $userId, Carbon $startedAt, array $tasks)
    {
        $this->userId = $userId;
        $this->startedAt = $startedAt;
        $this->tasks = $tasks;
    }

    public function handle()
    {
        return new ExamSession([
            'userId' => $this->userId,
            'startedAt' => $this->startedAt,
            'tasksIds' => json_encode($this->tasks),
        ]);
    }
}
