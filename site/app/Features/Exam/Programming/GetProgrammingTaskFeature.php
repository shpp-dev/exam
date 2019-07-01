<?php

namespace App\Features\Exam\Programming;

use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\Domains\Data\Jobs\GetPreparedTaskDataJob;
use App\Domains\Exam\Programming\Jobs\SelectLastUnsolvedTaskJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Features\Exam\Session\StartExamFeature;
use App\ProgrammingTask;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;
use Lucid\Foundation\ServesFeaturesTrait;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class GetProgrammingTaskFeature extends Feature
{
    use ServesFeaturesTrait;

    public function handle()
    {
        $user = Auth::getAuthUser();
        $session = $user->activeSession();

        if (!$session) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'code' => 420,
                'message' => ExamSystem::NOT_ACTIVE_SESSION_ERROR
            ]);
        }

        if ($session->programmingStatus == ExamSystem::PREPARED_STATUS) {
            try {
                $this->serve(StartExamFeature::class, [
                    'session' => $session,
                    'examName' => ExamSystem::PROGRAMMING_EXAM_NAME
                ]);
            } catch (ConflictHttpException $e) {
                return $this->run(RespondWithJsonErrorJob::class, [
                    'code' => 409,
                    'message' => ExamSystem::CONCURRENT_EXAM_ERROR
                ]);
            }
        } elseif ($session->programmingStatus != ExamSystem::IN_PROGRESS_STATUS) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'code' => 418,
                'message' => ExamSystem::NOT_ACTIVE_EXAM_ERROR
            ]);
        }

        $unsolvedTaskId = $this->run(SelectLastUnsolvedTaskJob::class, [
            'examSession' => $session
        ]);

        $task = ProgrammingTask::find($unsolvedTaskId);

        $preparedContent = $this->run(GetPreparedTaskDataJob::class, [
            'task' => $task,
            'examSession' => $session
        ]);

        Log::info('Task '. $task->id.' description sent to user '.$user->id);

        return $this->run(RespondWithJsonJob::class, [
            'content' => $preparedContent
        ]);
    }
}
