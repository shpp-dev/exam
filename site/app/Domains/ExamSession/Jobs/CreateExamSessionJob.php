<?php

namespace App\Domains\ExamSession\Jobs;


use App\Data\ExamSystem;
use App\ExamSession;
use Carbon\Carbon;
use Lucid\Foundation\Job;

class CreateExamSessionJob extends Job
{
    private $userId;
    private $startedAt;
    private $programmingTasks;
    private $programmingExam;
    private $englishExam;
    private $typeSpeedExam;

    public function __construct(
        int $userId,
        Carbon $startedAt,
        array $programmingTasks,
        bool $programmingExam,
        bool $englishExam,
        bool $typeSpeedExam
    ) {
        $this->userId = $userId;
        $this->startedAt = $startedAt;
        $this->programmingTasks = $programmingTasks;
        $this->programmingExam = $programmingExam;
        $this->englishExam = $englishExam;
        $this->typeSpeedExam = $typeSpeedExam;
    }

    public function handle()
    {
        $examSession = new ExamSession([
            'user_id' => $this->userId,
            'started_at' => $this->startedAt,
            'programming_tasks_ids' => json_encode($this->programmingTasks),
            'programming_status' => $this->programmingExam ? ExamSystem::IN_PROGRESS_STATUS : ExamSystem::DISABLED_STATUS,
            'english_status' => $this->englishExam ? ExamSystem::IN_PROGRESS_STATUS : ExamSystem::DISABLED_STATUS,
            'type_speed_status' => $this->typeSpeedExam ? ExamSystem::IN_PROGRESS_STATUS : ExamSystem::DISABLED_STATUS
        ]);

        $examSession->save();

        return $examSession;
    }
}
