<?php


namespace App\Features\Exam\English;


use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\Domains\Exam\English\Jobs\CreateEnglishResultJob;
use App\Domains\Exam\English\Jobs\SaveAnswerJob;
use App\Domains\Exam\English\Jobs\SelectLastUnsolvedTaskJob;
use App\Domains\Exam\Session\Jobs\CheckFinishedExamJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Features\Exam\Session\FinishExamFeature;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;
use Lucid\Foundation\ServesFeaturesTrait;

class SaveEnglishAnswerFeature extends Feature
{
    use ServesFeaturesTrait;

    public function handle(Request $request)
    {
        $user = Auth::getAuthUser();
        $session = $user->activeSession();

        $isFinished = $this->run(CheckFinishedExamJob::class, [
            'session' => $session,
            'examName' => ExamSystem::ENGLISH_EXAM_NAME
        ]);

        if ($isFinished) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => ExamSystem::EXAM_WAS_FINISHED
            ]);
        }

        $englishResult = $session->englishResult()->first();

        if (!$englishResult) {
            $englishResult = $this->run(CreateEnglishResultJob::class, [
                'session' => $session
            ]);
        }

        try {
            $task = $this->run(SelectLastUnsolvedTaskJob::class, [
                'session' => $session,
            ]);
        } catch (Exception $exception) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'code' => 500,
                'status' => 500,
                'message' => ExamSystem::ENGLISH_QUESTIONS_STORAGE_ERROR
            ]);
        }

        $this->run(SaveAnswerJob::class, [
            'englishResult' => $englishResult,
            'task' => $task,
            'answer' => $request->input('answer')
        ]);

        if ($englishResult->answersAmount == config('ptp.englishQuestionsAmount')) {
            $finished = $this->serve(FinishExamFeature::class, [
                'session' => $session,
                'examName' => ExamSystem::ENGLISH_EXAM_NAME
            ]);
        } else {
            $finished = [
                'english' => false,
                'session' => false
            ];
        }

        Log::info('User' . $user->id . ' submit answer to english question');

        return $this->run(RespondWithJsonJob::class, [
            'content' => [
                'score' => $englishResult->score ?? 0,
                'finished' => $finished
            ]
        ]);
    }
}
