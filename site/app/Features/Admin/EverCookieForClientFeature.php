<?php


namespace App\Features\Admin;


use App\Data\ExamSystem;
use App\Domains\Auth\Jobs\RemoveEverCookieJob;
use App\Domains\Auth\Jobs\UpdateEverCookieJob;
use App\Domains\Http\Jobs\RespondWithJsonAndCookieJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;

class EverCookieForClientFeature extends Feature
{
    /**
     * @var string
     */
    private $action;

    public function __construct(string $action)
    {
        $this->action = $action;
    }

    public function handle(Request $request)
    {
        $clientForExamData = json_decode($request->cookie('clientForExam'), true);

        switch ($this->action) {
            case 'save':
                $this->run(UpdateEverCookieJob::class, [
                    'clientLocation' => $request->clientLocation,
                    'clientId' => $request->clientId,
                    'token' => $request->token,
                ]);
                return $this->run(RespondWithJsonAndCookieJob::class, [
                    'cookie' => [
                        'name' => 'clientForExam',
                        'value' => json_encode([
                            'clientId' => $request->clientId,
                            'clientLocation' => $request->clientLocation,
                            'token' => $request->token
                        ]),
                        'expiration' => ExamSystem::FIVE_YEARS_IN_SECONDS,
                        'path' => '/',
                        'domain' => config('auth.domain')
                    ]
                ]);
            case 'remove':
                $this->run(RemoveEverCookieJob::class, [
                    'clientLocation' => $clientForExamData['clientLocation'],
                    'clientId' => $clientForExamData['clientId']
                ]);
                break;
            default:
                return $this->run(RespondWithJsonErrorJob::class);
        }
    }
}
