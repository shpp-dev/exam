<?php


namespace App\Features\Admin;


use App\Data\ExamSystem;
use App\Domains\Data\Jobs\GetPreparedUsersResultsListJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\ExamSession;
use Lucid\Foundation\Feature;

class GetUsersExamsFeature extends Feature
{
    private $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function handle()
    {
        switch ($this->status) {
            case 'all':
                $sessions = ExamSession::whereNotNull('finished_at')->get();
                break;
            case 'unchecked':
                $sessions = ExamSession::where('passed', null)->whereNotNull('finished_at')->get();
                break;
            case 'passed':
                $sessions = ExamSession::where('passed', true)->whereNotNull('finished_at')->get();
                break;
            case 'failed':
                $sessions = ExamSession::where('passed', false)->whereNotNull('finished_at')->get();
                break;
            default:
                return $this->run(RespondWithJsonErrorJob::class, [
                    'message' => ExamSystem::STATUS_NOT_FOUND
                ]);
        }

        $preparedData = $this->run(GetPreparedUsersResultsListJob::class, [
            'sessions' => $sessions
        ]);

        return $this->run(RespondWithJsonJob::class, [
            'content' => $preparedData
        ]);
    }
}
