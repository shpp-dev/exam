<?php


namespace App\Features\Exam\Session;


use App\Domains\Auth\Auth;
use App\Domains\Exam\Session\Jobs\SaveFeedbackAboutExamJob;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class SaveFeedbackAboutExamFeature extends Feature
{
    public function handle(Request $request)
    {
        $this->run(SaveFeedbackAboutExamJob::class, [
            'user' => Auth::getAuthUser(),
            'feedback' => $request->feedback
        ]);
    }
}
