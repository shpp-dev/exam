<?php


namespace App\Features\User;


use App\Domains\Mail\Jobs\CreateUserJob;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;
use Lucid\Foundation\ServesFeaturesTrait;

class CreateUserFeature extends Feature
{
    use ServesFeaturesTrait;

    public function handle(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $users = $data['users'];

        foreach ($users as $user) {
            $this->run(CreateUserJob::class, [
                'accountId' => $user['accountId'],
                'email' => $user['email']
            ]);
        }
    }
}
