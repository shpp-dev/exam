<?php


namespace App\Domains\Exam\English\Jobs;


use App\Data\ExamSystem;
use App\ExamSession;
use InvalidArgumentException;
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
        $englishResult = $this->session->englishResult()->first();
        $nextTaskId = 1;

        if ($englishResult) {
            $nextTaskId = $englishResult->answersAmount + 1;
        }

        $tasks = json_decode(file_get_contents(ExamSystem::ENGLISH_QUESTIONS_PATH), true);

        if (!array_key_exists($nextTaskId, $tasks)) {
            throw new InvalidArgumentException('non-existent task number');
        }

        return [
            'taskNumber' => $nextTaskId,
            'question' => $tasks[$nextTaskId]['question'],
            'answers' => $tasks[$nextTaskId]['answers']
        ];
    }
}
