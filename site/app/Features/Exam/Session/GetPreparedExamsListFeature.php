<?php


namespace App\Features\Exam\Session;


use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;

class GetPreparedExamsListFeature extends Feature
{
    public function handle()
    {
        $user = Auth::getAuthUser();
        $session = $user->activeSession();

        if (!$session) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => ExamSystem::NOT_ACTIVE_SESSION_ERROR
            ]);
        }

        $exams = [];
        $statusMap = [
            ExamSystem::PREPARED_STATUS => 'prepared',
            ExamSystem::IN_PROGRESS_STATUS => 'inProgress',
            ExamSystem::FINISHED_STATUS => 'finished'
        ];

        if ($session->programmingStatus != ExamSystem::DISABLED_STATUS) {
            $exams[ExamSystem::PROGRAMMING_EXAM_NAME] = $statusMap[$session->programmingStatus];
        }

        if ($session->englishStatus != ExamSystem::DISABLED_STATUS) {
            $exams[ExamSystem::ENGLISH_EXAM_NAME] = $statusMap[$session->englishStatus];
        }

        if ($session->typeSpeedStatus != ExamSystem::DISABLED_STATUS) {
            $exams[ExamSystem::TYPE_SPEED_EXAM_NAME] = $statusMap[$session->typeSpeedStatus];
        }

        Log::info('Current exams list for user ' . $user->id . ': ' . implode(', ', array_keys($exams)));

        return $this->run(RespondWithJsonJob::class, [
            'content' => [
                'examsList' => $exams
            ]
        ]);
    }
}
