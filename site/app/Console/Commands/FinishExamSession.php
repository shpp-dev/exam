<?php

namespace App\Console\Commands;

use App\Data\ExamSystem;
use App\ExamSession;
use App\Features\Exam\Session\FinishExamFeature;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Lucid\Foundation\ServesFeaturesTrait;

class FinishExamSession extends Command
{
    use ServesFeaturesTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exam:finish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Forced finish exam session after deadline';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $notClosedSessions = ExamSession::where('finished_at', null);

        foreach ($notClosedSessions as $session) {
            // check programming exam duration
            if ($session->programmingStatus == ExamSystem::IN_PROGRESS_STATUS
                && Carbon::instance($session->programmingStartedAt) < Carbon::now()->subMinutes(config('ptp.programmingExamDurationMins'))) {
                $this->serve(FinishExamFeature::class, [
                    'examName' => ExamSystem::PROGRAMMING_EXAM_NAME,
                    'session' => $session
                ]);
            }

            // check english exam duration
            if ($session->englishStatus == ExamSystem::IN_PROGRESS_STATUS
                && Carbon::instance($session->englishStartedAt) < Carbon::now()->subMinutes(config('ptp.englishExamDurationMins'))) {
                $this->serve(FinishExamFeature::class, [
                    'examName' => ExamSystem::ENGLISH_EXAM_NAME,
                    'session' => $session
                ]);
            }
        }
    }
}
