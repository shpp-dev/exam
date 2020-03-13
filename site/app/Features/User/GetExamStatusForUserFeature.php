<?php


namespace App\Features\User;


use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\User\Jobs\GetExamRetryFromDateJob;
use App\Domains\User\Jobs\GetUserByEmailJob;
use App\Domains\User\Jobs\GetExamStatusForUserJob;
use App\Operations\Auth\CheckLocationOperation;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class GetExamStatusForUserFeature extends Feature
{
    public function handle(Request $request)
    {
        $requestData = json_decode($request->getContent(), true);

        $user = $this->run(GetUserByEmailJob::class, [
            'email' => $requestData['email']
        ]);

        $locationIdentified = $this->run(CheckLocationOperation::class, [
            'user' => $user,
            'clientLocation' => $requestData['clientForExam']['clientLocation'] ?? null,
            'clientId' => $requestData['clientForExam']['clientId'] ?? null,
            'token' => $requestData['clientForExam']['token'] ?? null
        ]);

        $examData = [
            'status' => $this->run(GetExamStatusForUserJob::class, [
                'user' => $user,
                'locationIdentified' => $locationIdentified
            ]),
            'location' => null,
            'datetime' => null,
            'retryFrom' => null
        ];

        if ($examData['status'] === ExamSystem::EXAM_TODAY || $examData['status'] === ExamSystem::EXAM_PENDING) {
            $examData['location'] = $user->exam_location;
            $examData['datetime'] = $user->exam_datetime;
        }

        if ($examData['status'] === ExamSystem::EXAM_FAILED) {
            $examData['retryFrom'] = $this->run(GetExamRetryFromDateJob::class, ['user' => $user]);
        }

        return $this->run(RespondWithJsonJob::class, [
            'content' => $examData
        ]);
    }
}
