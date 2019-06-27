<?php

namespace App\Domains\Data\Jobs;


use App\Data\ExamSystem;
use App\ExamSession;
use Carbon\Carbon;
use Lucid\Foundation\Job;

class GetPreparedUsersResultsListJob extends Job
{
    /**
     * @var
     */
    private $sessions;

    /**
     * GetPreparedUncheckedUsersListJob constructor.
     * @param $sessions
     */
    public function __construct($sessions)
    {
        $this->sessions = $sessions;
    }

    public function handle()
    {
        $preparedData = ['exams' => []];

        /* @var ExamSession $session */
        foreach ($this->sessions as $session) {
            $examData = [
                'sessionId' => $session->id,
                'timing' => [
                    'startedAtTs' => Carbon::parse($session->startedAt)->timestamp * ExamSystem::JAVASCRIPT_TIMESTAMP_COEFFICIENT,
                    'finishedAtTs' => Carbon::parse($session->finishedAt)->timestamp * ExamSystem::JAVASCRIPT_TIMESTAMP_COEFFICIENT
                ],
                'passed' => $session->passed,
                'programming' => [],
                'english' => [],
                'typeSpeed' => []
            ];

            $programmingResults = $session->programmingResults()->get();
            foreach ($programmingResults as $result) {
                $solution = json_decode($result->result, true);
                $examData['programming'][] = [
                    'task' => [
                        'id' => $result->taskId,
                        'number' => $result->taskNumber,
                        'name' => $result->task->name,
                        'description' => json_decode($result->task->description, true)
                    ],
                    'solution' => [
                        'userFunction' => $solution['userFunction'],
                        'caseResults' => $solution['resultCases']
                    ]
                ];
            }

            $englishResult = $session->englishResult()->first();
            if ($englishResult) {
                $examData['english'] = [
                    'answers' => $englishResult->answersAmount,
                    'score' => $englishResult->score
                ];
            }

            $typeSpeedResult = $session->typeSpeedResult()->first();
            if ($typeSpeedResult) {
                $examData['typeSpeed'] = [
                    'speed' => $typeSpeedResult->speed,
                    'accuracy' => $typeSpeedResult->accuracy
                ];
            }

            $preparedData['exams'][] = $examData;
        }

        return $preparedData;
    }
}
