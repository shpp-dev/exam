<?php


namespace App\Features\Admin;


use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\User\Jobs\GetUserByEmailJob;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class GetExamDataForUsersFeature extends Feature
{
    public function handle(Request $request)
    {
        $emails = json_decode($request->getContent(), true)['emails'] ?? null;
        $preparedData = [];

        if ($emails) {
            foreach ($emails as $email) {
                /* @var User $user */
                $user = $this->run(GetUserByEmailJob::class, ['email' => $email]);

                if ($user) {
                    $lastExamSession = $user->lastFinishedExamSession();

                    if ($lastExamSession) {
                        $preparedData[$email] = [
                            'examDate' => Carbon::parse($lastExamSession->finished_at)->toDateString()
                        ];
                    }
                }
            }
        }

        return $this->run(RespondWithJsonJob::class, [
            'content' => $preparedData
        ]);
    }
}
