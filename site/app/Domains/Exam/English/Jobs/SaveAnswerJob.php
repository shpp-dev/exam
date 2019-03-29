<?php


namespace App\Domains\Exam\English\Jobs;


use App\Data\ExamSystem;
use App\EnglishResult;
use Lucid\Foundation\Job;

class SaveAnswerJob extends Job
{
    private $englishResult;
    private $taskNumber;
    private $answer;

    public function __construct(EnglishResult $englishResult, int $taskNumber, int $answer)
    {
        $this->englishResult = $englishResult;
        $this->taskNumber = $taskNumber;
        $this->answer = $answer;
    }

    public function handle()
    {
        $isCorrectAnswer = false;
        $task = json_decode(file_get_contents(base_path(ExamSystem::ENGLISH_QUESTIONS_PATH)), true)[$this->taskNumber];
        $results = json_decode($this->englishResult->results, true);

        if (!$results) {
            $results = [];
        }

        if (!isset($results[$this->taskNumber])) {
            $results[$this->taskNumber] = [
                'question' => $task['question'],
                'answers' => $task['answers'],
                'answer' => $this->answer
            ];

            $this->englishResult->results = json_encode($results);
            $this->englishResult->answersAmount++;

            if ($task['right'] == $this->answer) {
                $this->englishResult->score++;
                $isCorrectAnswer = true;
            }

            $this->englishResult->save();
        } else {
            $isCorrectAnswer = $task['right'] == $results[$this->taskNumber][$this->answer];
        }

        return $isCorrectAnswer;
    }
}
