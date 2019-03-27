<?php


namespace App\Domains\Exam\English\Jobs;


use App\EnglishResult;
use Lucid\Foundation\Job;

class SaveAnswerJob extends Job
{
    private $englishResult;
    private $task;
    private $answer;

    public function __construct(EnglishResult $englishResult, array $task, int $answer)
    {
        $this->englishResult = $englishResult;
        $this->task = $task;
        $this->answer = $answer;
    }

    public function handle()
    {
        $results = json_decode($this->englishResult->results, true);

        if (!$results) {
            $results = [];
        }

        $results[] = [
            'question' => $this->task['question'],
            'answers' => $this->task['answers'],
            'answer' => $this->answer
        ];

        $this->englishResult->results = json_encode($results);
        $this->englishResult->answersAmount++;

        if ($this->task['right'] == $this->answer) {
            $this->englishResult->score++;
        }

        $this->englishResult->save();
    }
}
