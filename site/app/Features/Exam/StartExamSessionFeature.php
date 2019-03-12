<?php

namespace App\Features\Exam;

use App\Domains\Auth\Auth;
use App\Domains\Exam\Jobs\CreateExamSessionJob;
use App\Domains\Exam\Jobs\SelectTasksJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;

class StartExamSessionFeature extends Feature
{
    public function handle()
    {
        $user = Auth::getAuthUser();

        $tasks = $this->run(SelectTasksJob::class, [
           'amount' => config('ptp.tasksOnExam')
        ]);

        $this->run(CreateExamSessionJob::class, [
            'userId' => $user->id,
            'startedAt' => Carbon::now(),
            'tasks' => $tasks
        ]);
        Log::info('Exam session started for user '.$user->id);
    }
}
