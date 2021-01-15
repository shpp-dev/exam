<?php


namespace App\Features\Admin;


use App\Data\ExamSystem;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\User\Jobs\DisableCheckingLocationForUserJob;
use App\Domains\User\Jobs\GetUserByEmailJob;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class DisableCheckingLocationFeature extends Feature
{
     public function handle(Request $request)
     {
         $user = $this->run(GetUserByEmailJob::class, ['email' => $request->email]);

         if (!$user) {
             return $this->run(RespondWithJsonErrorJob::class, [
                 'code' => 404,
                 'message' => ExamSystem::USER_NOT_FOUND
             ]);
         }

         $this->run(DisableCheckingLocationForUserJob::class, ['user' => $user]);
     }
}
