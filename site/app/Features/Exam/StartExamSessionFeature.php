<?php

namespace App\Features\Exam;

use App\Domains\Auth\Auth;
use App\Domains\Exam\Jobs\CreateExamSessionJob;
use App\Domains\Exam\Jobs\SelectTasksJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class StartExamSessionFeature extends Feature
{
    public function handle(Request $request)
    {
        $user = Auth::getAuthUser();

        $tasks = $this->run(SelectTasksJob::class, [
           'amount' => config('ptp.tasksOnExam')
        ]);

        $session = $this->run(CreateExamSessionJob::class, [
            'userId' => $user->id,
            'startedAt' => Carbon::now(),
            'tasks' => $tasks
        ]);
    }
}
