<?php


namespace App\Features\Exam\TypeSpeed;


use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\Domains\Exam\Session\Jobs\CheckAllExamsFinishedJob;
use App\Domains\Exam\Session\Jobs\FinishExamByNameJob;
use App\Domains\Exam\TypeSpeed\Jobs\CreateTypeSpeedResultJob;
use App\Features\Exam\Session\FinishExamSessionFeature;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;
use Lucid\Foundation\ServesFeaturesTrait;

class SaveTypeSpeedFeature extends Feature
{
    use ServesFeaturesTrait;

    public function handle(Request $request)
    {
        $user = Auth::getAuthUser();
        $session = $user->activeSession();

        $this->run(CreateTypeSpeedResultJob::class, [
            'session' => $session,
            'speed' => $request->input('speed'),
            'accuracy' => $request->input('accuracy')
        ]);

        $this->run(FinishExamByNameJob::class, [
            'session' => $session,
            'examName' => ExamSystem::TYPE_SPEED_EXAM_NAME
        ]);

        if ($this->run(CheckAllExamsFinishedJob::class)) {
            $this->serve(FinishExamSessionFeature::class);
        }
    }
}
