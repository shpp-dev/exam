<?php


namespace App\Features\Admin;


use App\Data\ExamSystem;
use App\Domains\Auth\Jobs\RemoveEverCookieJob;
use App\Domains\Auth\Jobs\SaveLocationJob;
use App\Domains\Auth\Jobs\UpdateEverCookieJob;
use App\Domains\Http\Jobs\RespondWithJsonAndCookieJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use Illuminate\Http\Request;
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
                $locationId = $request->locationId;
                $locationAddress = $request->locationAddress;
                $clientId = $request->clientId;
                $token = $request->token;

                $this->run(SaveLocationJob::class, [
                    'name' => $locationId,
                    'address' => $locationAddress
                ]);

                $this->run(UpdateEverCookieJob::class, [
                    'clientLocation' => $locationId,
                    'clientId' => $clientId,
                    'token' => $token,
                ]);

                return $this->run(RespondWithJsonAndCookieJob::class, [
                    'cookie' => [
                        'name' => 'clientForExam',
                        'value' => json_encode([
                            'clientId' => $clientId,
                            'clientLocation' => $locationId,
                            'token' => $token
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
