<?php


namespace App\Features\User;


use App\Data\ExamSystem;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\User\Jobs\GetUserByEmailJob;
use App\Domains\User\Jobs\GetExamStatusForUserJob;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class GetExamStatusForUserFeature extends Feature
{
    public function handle(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];

        $user = $this->run(GetUserByEmailJob::class, [
            'email' => $email
        ]);

        $status = $this->run(GetExamStatusForUserJob::class, [
            'user' => $user
        ]);

        return $this->run(RespondWithJsonJob::class, [
            'content' => [
                'status' => $status
            ]
        ]);
    }
}
