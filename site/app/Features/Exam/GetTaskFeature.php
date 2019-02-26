<?php

namespace App\Features\Exam;

use App\Domains\Auth\Auth;
use App\Domains\Exam\Jobs\GetPreparedTaskDataJob;
use App\Domains\Exam\Jobs\SelectLastUnsolvedTaskJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Task;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class GetTaskFeature extends Feature
{
    public function handle(Request $request)
    {
        $user = Auth::getAuthUser();
        $session = $user->activeSession();

        $unsolvedTaskId = $this->run(SelectLastUnsolvedTaskJob::class, [
            'examSession' => $session
        ]);

        $task = Task::find($unsolvedTaskId);

        $preparedContent = $this->run(GetPreparedTaskDataJob::class, [
            'task' => $task,
            'examSession' => $session
        ]);

        return $this->run(RespondWithJsonJob::class, [
            'content' => $preparedContent
        ]);
    }
}
