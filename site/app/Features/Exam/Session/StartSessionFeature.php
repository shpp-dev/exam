<?php

namespace App\Features\Exam\Session;

use App\Domains\Auth\Auth;
use App\Domains\Exam\Session\Jobs\CreateExamSessionJob;
use App\Domains\Exam\Programming\Jobs\SelectTasksJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;

class StartSessionFeature extends Feature
{
    public function handle()
    {
        $user = Auth::getAuthUser();

        $programmingTasks = config('ptp.programmingExam')
            ? $this->run(SelectTasksJob::class, ['amount' => config('ptp.programmingTasksAmount')])
            : null;

        $this->run(CreateExamSessionJob::class, [
            'userId' => $user->id,
            'startedAt' => Carbon::now(),
            'programmingTasks' => $programmingTasks,
            'programmingExam' => config('ptp.programmingExam'),
            'englishExam' => config('ptp.englishExam'),
            'typeSpeedExam' => config('ptp.typeSpeedExam')
        ]);

        Log::info('Exam session started for user '.$user->id);
    }
}
