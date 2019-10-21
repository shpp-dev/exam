<?php


namespace App\Features\Admin;


use App\Domains\User\Jobs\DisableCheckingLocationForUserJob;
use App\Domains\User\Jobs\GetUserByEmailJob;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class DisableCheckingLocationFeature extends Feature
{
     public function handle(Request $request)
     {
         $user = $this->run(GetUserByEmailJob::class, ['email' => $request->email]);
         $this->run(DisableCheckingLocationForUserJob::class, ['user' => $user]);
     }
}
