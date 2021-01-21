<?php


namespace App\Features\Exam\Session;


use App\Domains\Auth\Auth;
use App\Domains\Exam\Session\Jobs\SaveZeroStatusForUserJob;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class SaveZeroStatusForUserFeature extends Feature
{
    public function handle(Request $request)
    {
        $this->run(SaveZeroStatusForUserJob::class, [
            'user' => Auth::getAuthUser(),
            'zeroStatus' => $request->zeroStatus ?? null
        ]);
    }

}
