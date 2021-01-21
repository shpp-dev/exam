<?php


namespace App\Features\Exam\Session;


use App\Domains\Auth\Auth;
use App\Domains\Exam\Session\Jobs\CheckAllExamsFinishedJob;
use App\Domains\Exam\Session\Jobs\FinishExamByNameJob;
use App\ExamSession;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;
use Lucid\Foundation\ServesFeaturesTrait;

class FinishExamFeature extends Feature
{
    use ServesFeaturesTrait;

    private $examName;
    private $session;
    private $forced;

    public function __construct(string $examName, ExamSession $session = null, bool $forced = false)
    {
        $this->session = $session;
        $this->examName = $examName;
        $this->forced = $forced;
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

        $finished = [
            $this->examName => true,
            'session' => false
        ];

        if ($this->run(CheckAllExamsFinishedJob::class, ['session' => $this->session])) {
            $this->serve(FinishSessionFeature::class, ['session' => $this->session, 'forced' => $this->forced]);
            $finished['session'] = true;
        }

        Log::info(ucfirst($this->examName) . ' exam finished for user '. $this->session->userId);

        return $finished;
    }
}
