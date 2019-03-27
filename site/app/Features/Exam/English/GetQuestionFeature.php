<?php


namespace App\Features\Exam\English;


use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\Domains\Exam\English\Jobs\SelectLastUnsolvedTaskJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Exception;
use Lucid\Foundation\Feature;

class GetQuestionFeature extends Feature
{
    public function handle()
    {
        $user = Auth::getAuthUser();
        $session = $user->activeSession();

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

        return $this->run(RespondWithJsonJob::class, [
            'content' => [
                'question' => $task['question'],
                'answers' => json_encode($task['answers'])
            ]
        ]);
    }
}
