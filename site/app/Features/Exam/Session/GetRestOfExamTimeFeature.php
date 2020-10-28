<?php


namespace App\Features\Exam\Session;


use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\Domains\Exam\Session\Jobs\GetRestOfExamTimeJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;

class GetRestOfExamTimeFeature extends Feature
{
    private $examType;

    public function __construct(string $examType)
    {
        $this->examType = $examType;
    }

    public function handle()
    {
        $user = Auth::getAuthUser();
        $session = $user->activeSession();

        if (!$session) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'code' => 420,
                'message' => ExamSystem::NOT_ACTIVE_SESSION_ERROR
            ]);
        }

        $restOfSeconds = $this->run(GetRestOfExamTimeJob::class, [
            'examSession' => $session,
            'examType' => $this->examType
        ]);

        return $this->run(RespondWithJsonJob::class, [
            'content' => [
                'restOfSeconds' => $restOfSeconds
            ]
        ]);
    }
}
