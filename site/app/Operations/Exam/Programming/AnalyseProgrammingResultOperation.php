<?php


namespace App\Operations\Exam\Programming;


use Lucid\Foundation\Operation;

class AnalyseProgrammingResultOperation extends Operation
{
    private $programmingResults;

    public function __construct($programmingResults)
    {
        $this->programmingResult = $programmingResults;
    }

    public function handle()
    {
        $results = [];

        foreach ($this->programmingResults as $programmingResult) {
            $results[$programmingResult->task_number] = json_decode($programmingResult->result, true);
        }

        if (count($results) < 4) {
            return 'failed';
        }

        if ($this->isTaskPassed($results[3] ?? null) && $this->isTaskPassed($results[4] ?? null)) {
            return 'passed';
        }

        return 'manualCheck';
    }

    private function isTaskPassed(?array $result)
    {
        if (!$result) {
            return false;
        }

        foreach ($result['resultCases'] as $passed) {
            if ($passed !== true) {
                return false;
            }
        }

        return true;
    }
}
