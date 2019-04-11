<?php


namespace App\Features\Admin;


use App\Domains\Data\Jobs\GetPreparedUsersResultsListJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\ExamSession;
use Lucid\Foundation\Feature;

class GetUsersListFeature extends Feature
{
    private $passed;

    public function __construct(?bool $passed)
    {
        $this->passed = $passed;
    }

    public function handle()
    {
        $sessions = ExamSession::where('passed', $this->passed)->get();

        $preparedData = $this->run(GetPreparedUsersResultsListJob::class, [
            'sessions' => $sessions
        ]);

        return $this->run(RespondWithJsonJob::class, [
            'content' => $preparedData
        ]);
    }
}
