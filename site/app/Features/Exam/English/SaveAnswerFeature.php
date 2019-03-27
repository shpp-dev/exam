<?php


namespace App\Features\Exam\English;


use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\Domains\Exam\English\Jobs\CreateEnglishResultJob;
use App\Domains\Exam\English\Jobs\SaveAnswerJob;
use App\Domains\Exam\English\Jobs\SelectLastUnsolvedTaskJob;
use App\Domains\Exam\Session\Jobs\CheckAllExamsFinishedJob;
use App\Domains\Exam\Session\Jobs\FinishExamByNameJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Features\Exam\Session\FinishExamSessionFeature;
use Exception;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;
use Lucid\Foundation\ServesFeaturesTrait;

class SaveAnswerFeature extends Feature
{
    use ServesFeaturesTrait;

    public function handle(Request $request)
    {
        $user = Auth::getAuthUser();
        $session = $user->activeSession();
        $finished = false;

        $englishResult = $session->englishResult();

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

        if ($englishResult->answerAmounts == config('ptp.englishQuestionsOnExam')) {
            $finished = true;
            $this->run(FinishExamByNameJob::class, [
                'session' => $session,
                'examName' => ExamSystem::ENGLISH_EXAM_NAME
            ]);

            if ($this->run(CheckAllExamsFinishedJob::class, [
                'session' => $session
            ])) {
                $this->serve(FinishExamSessionFeature::class);
            }
        }

        return $this->run(RespondWithJsonJob::class, [
            'content' => [
                'score' => $englishResult->score,
                'finished' => $finished
            ]
        ]);
    }
}
