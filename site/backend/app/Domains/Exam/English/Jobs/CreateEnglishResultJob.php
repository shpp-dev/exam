<?php


namespace App\Domains\Exam\English\Jobs;


use App\EnglishResult;
use App\ExamSession;
use Lucid\Foundation\Job;

class CreateEnglishResultJob extends Job
{
    private $session;

    public function __construct(ExamSession $session)
    {
        $this->session = $session;
    }

    public function handle()
    {
        $englishResult = new EnglishResult();
        $englishResult->sessionId = $this->session->id;
        $englishResult->save();

        return $englishResult;
    }
}