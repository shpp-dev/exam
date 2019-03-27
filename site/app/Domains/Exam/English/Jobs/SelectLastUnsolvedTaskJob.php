<?php


namespace App\Domains\Exam\English\Jobs;


use App\Data\ExamSystem;
use App\ExamSession;
use Lucid\Foundation\Job;

class SelectLastUnsolvedTaskJob extends Job
{
    private $session;

    public function __construct(ExamSession $session)
    {
        $this->session = $session;
    }

    public function handle()
    {
        $englishResult = $this->session->englishResult();
        $taskId = 0;

        if ($englishResult) {
            $taskId = $englishResult->answersAmount;
        }

        return json_decode(file_get_contents(base_path(ExamSystem::ENGLISH_QUESTIONS_PATH)), true)[$taskId];
    }
}
