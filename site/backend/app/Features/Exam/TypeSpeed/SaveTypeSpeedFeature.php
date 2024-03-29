<?php


namespace App\Features\Exam\TypeSpeed;


use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\Domains\Exam\TypeSpeed\Jobs\CreateTypeSpeedResultJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Features\Exam\Session\FinishExamFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        $finished = $this->serve(FinishExamFeature::class, [
            'session' => $session,
            'examName' => ExamSystem::TYPE_SPEED_EXAM_NAME
        ]);

        Log::info('Save type speed for user' . $user->id);

        return $this->run(RespondWithJsonJob::class, [
            'content' => [
                'finished' => $finished
            ]
        ]);
    }
}
