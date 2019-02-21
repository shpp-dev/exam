<?php

namespace App\Domains\Exam\Jobs;


use App\ExamSession;
use App\Task;
use Carbon\Carbon;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Lucid\Foundation\Job;

class GetPreparedTaskDataJob extends Job
{
    public function __construct(Task $task)
    {
    }

    public function handle()
    {
    }
}
