<?php


namespace App\Features\Exam\Session;


use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\Domains\Exam\Session\Jobs\CheckActiveExamJob;
use App\Domains\Exam\Session\Jobs\StartExamByNameJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\ExamSession;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;

class StartExamFeature extends Feature
{
    private $examName;
    private $session;

    public function __construct(string $examName, ExamSession $session = null)
    {
        $this->examName = $examName;
        $this->session = $session;
    }

    public function handle()
    {
        if (!$this->session) {
            $user = Auth::getAuthUser();
            $this->session = $user->activeSession();
        }

        $hasActiveExam = $this->run(CheckActiveExamJob::class, [
            'session' => $this->session
        ]);

        if ($hasActiveExam) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => ExamSystem::CONCURRENT_EXAM_ERROR
            ]);
        }

        $this->run(StartExamByNameJob::class, [
            'session' => $this->session,
            'examName' => $this->examName
        ]);

        Log::info(ucfirst($this->examName) . ' exam started for user '. $this->session->userId);
    }
}
