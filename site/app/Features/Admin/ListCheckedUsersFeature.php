<?php

namespace App\Features\Exam;

use App\Domains\Auth\Auth;
use App\Domains\Exam\Jobs\CheckExamSessionJob;
use App\Domains\Exam\Jobs\GetPreparedUsersResultsListJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\SendHttpPostRequestJob;
use App\ExamSession;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class ListCheckedUsersFeature extends Feature
{
    public function handle(Request $request)
    {
        $checkedSessions = ExamSession::whereNotNull('passed')->get();

        $preparedData = $this->run(GetPreparedUsersResultsListJob::class, [
            'sessions' => $checkedSessions
        ]);

        return $this->run(RespondWithJsonJob::class, [
            'content' => $preparedData
        ]);
    }
}
