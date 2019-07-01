<?php


namespace App\Features\Exam\English;


use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\Domains\Exam\English\Jobs\SelectLastUnsolvedTaskJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Features\Exam\Session\StartExamFeature;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;
use Lucid\Foundation\ServesFeaturesTrait;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class GetEnglishQuestionFeature extends Feature
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

        if ($session->englishStatus == ExamSystem::PREPARED_STATUS) {
            try {
                $this->serve(StartExamFeature::class, [
                    'session' => $session,
                    'examName' => ExamSystem::ENGLISH_EXAM_NAME
                ]);
            } catch (ConflictHttpException $e) {
                return $this->run(RespondWithJsonErrorJob::class, [
                    'code' => 409,
                    'message' => ExamSystem::CONCURRENT_EXAM_ERROR
                ]);
            }
        } elseif ($session->englishStatus != ExamSystem::IN_PROGRESS_STATUS) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'code' => 418,
                'message' => ExamSystem::NOT_ACTIVE_EXAM_ERROR
            ]);
        }

        try {
            $task = $this->run(SelectLastUnsolvedTaskJob::class, [
                'session' => $session,
            ]);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return $this->run(RespondWithJsonErrorJob::class, [
                'code' => 500,
                'status' => 500,
                'message' => $exception->getMessage()
            ]);
        }

        Log::info('Task question: ' . $task['question'] . ' for user ' . $user->id);

        return $this->run(RespondWithJsonJob::class, [
            'content' => [
                'task' => $task,
                'tasksAmount' => config('ptp.englishQuestionsAmount'),
                'deadlineTs' => Carbon::parse($session->englishStartedAt)->addMinutes(config('ptp.englishExamDurationMins'))->timestamp
            ]
        ]);
    }
}
