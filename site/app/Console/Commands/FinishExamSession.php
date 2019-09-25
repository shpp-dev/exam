<?php

namespace App\Console\Commands;

use App\Data\ExamSystem;
use App\ExamSession;
use App\Features\Exam\Session\FinishExamFeature;
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
    protected $signature = 'exam:finish-session';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $notClosedSessions = ExamSession::where('finished_at', null)->get();

        foreach ($notClosedSessions as $session) {
            $this->serve(FinishExamFeature::class, [
                'examName' => ExamSystem::PROGRAMMING_EXAM_NAME,
                'session' => $session
            ]);

            $this->serve(FinishExamFeature::class, [
                'examName' => ExamSystem::ENGLISH_EXAM_NAME,
                'session' => $session
            ]);

            $this->serve(FinishExamFeature::class, [
                'examName' => ExamSystem::TYPE_SPEED_EXAM_NAME,
                'session' => $session
            ]);
        }
    }
}
