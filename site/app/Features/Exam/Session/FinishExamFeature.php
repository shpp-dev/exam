<?php


namespace App\Features\Exam\Session;


use App\Domains\Auth\Auth;
use App\Domains\Exam\Session\Jobs\CheckAllExamsFinishedJob;
use App\Domains\Exam\Session\Jobs\FinishExamByNameJob;
use App\ExamSession;
use Lucid\Foundation\Feature;
use Lucid\Foundation\ServesFeaturesTrait;

class FinishExamFeature extends Feature
{
    use ServesFeaturesTrait;

    private $examName;
    private $session;

    public function __construct(string $examName, ExamSession $session = null)
    {
        $this->session = $session;
        $this->examName = $examName;
    }

    public function handle()
    {
        if (!$this->session) {
            $user = Auth::getAuthUser();
            $this->session = $user->activeSession();
        }

        $this->run(FinishExamByNameJob::class, [
            'session' => $this->session,
            'examName' => $this->examName
        ]);

        if ($this->run(CheckAllExamsFinishedJob::class, ['session' => $this->session])) {
            $this->serve(FinishSessionFeature::class, ['session' => $this->session]);
        }
    }
}
