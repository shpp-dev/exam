<?php

namespace App\Domains\Data\Jobs;


use App\ExamSession;
use App\ProgrammingTask;
use Carbon\Carbon;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
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

        foreach ($this->sessions as $uncheckedSession) {
            $examData = [
                'sessionId' => $uncheckedSession->id,
                'timing' => [
                    'startedAtTs' => Carbon::parse($uncheckedSession->startedAt)->timestamp,
                    'finishedAtTs' => Carbon::parse($uncheckedSession->finishedAt)->timestamp
                ],
                'passed' => $uncheckedSession->passed,
                'results' => []
            ];
            $results = $uncheckedSession->results;
            foreach ($results as $result) {
                $solution = json_decode($result->result, true);
                $examData['results'][] = [
                    'task' => [
                        'id' => $result->taskId,
                        'number' => $result->taskNumber,
                        'name' => $result->task->name,
                        'description' => $result->task->description
                    ],
                    'solution' => [
                        'userFunction' => $solution['userFunction'],
                        'caseResults' => $solution['resultCases']
                    ]
                ];
            }
            $preparedData['exams'][] = $examData;
        }

        return $preparedData;
    }
}
