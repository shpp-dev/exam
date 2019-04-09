<?php


namespace App\Features\User;


use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\Domains\Exam\TypeSpeed\Jobs\CreateTypeSpeedResultJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Mail\Jobs\CreateUserJob;
use App\Features\Exam\Session\FinishExamFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;
use Lucid\Foundation\ServesFeaturesTrait;

class CreateUserFeature extends Feature
{
    use ServesFeaturesTrait;

    public function handle(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        foreach ($data['emails'] as $email) {
            $this->run(CreateUserJob::class, ['email' => $email]);
        }
    }
}
