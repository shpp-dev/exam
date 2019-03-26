<?php

namespace App\Features\Exam;

use App\Domains\Data\Jobs\GetPreparedUsersResultsListJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\ExamSession;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class ListUncheckedUsersFeature extends Feature
{
    public function handle(Request $request)
    {
        $uncheckedSessions = ExamSession::whereNull('passed')->get();

        $preparedData = $this->run(GetPreparedUsersResultsListJob::class, [
            'sessions' => $uncheckedSessions
        ]);

        return $this->run(RespondWithJsonJob::class, [
            'content' => $preparedData
        ]);
    }
}
