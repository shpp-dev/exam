<?php


namespace App\Features\Exam\Session;


use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;

class GetPreparedExamsListFeature extends Feature
{
    public function handle()
    {
        $user = Auth::getAuthUser();
        $session = $user->activeSession();

        $preparedExams = [];

        if ($session->programmingStatus == ExamSystem::PREPARED_STATUS) {
            $preparedExams[] = ExamSystem::PROGRAMMING_EXAM_NAME;
        }

        if ($session->englishStatus == ExamSystem::PREPARED_STATUS) {
            $preparedExams[] = ExamSystem::ENGLISH_EXAM_NAME;
        }

        if ($session->typeSpeedStatus == ExamSystem::PREPARED_STATUS) {
            $preparedExams[] = ExamSystem::TYPE_SPEED_EXAM_NAME;
        }

        Log::info('Current exams list for user ' . $user->id . ': ' . implode(', ', $preparedExams));

        return $this->run(RespondWithJsonJob::class, [
            'content' => [
                'examsList' => $preparedExams
            ]
        ]);
    }
}
