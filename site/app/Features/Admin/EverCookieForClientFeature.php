<?php


namespace App\Features\Admin;


use App\Domains\Auth\Jobs\RemoveEverCookieJob;
use App\Domains\Auth\Jobs\UpdateEverCookieJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;
use Exception;

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
        Log::info($request->clientIdentifier);

        switch ($this->action) {
            case 'save':
                $this->run(UpdateEverCookieJob::class, [
                    'newClientIdentifier' => $request->clientIdentifier,
                    'oldClientIdentifier' => $request->cookie('examClientIdentifier')
                ]);
                break;
            case 'remove':
                $this->run(RemoveEverCookieJob::class, [
                    'clientIdentifier' => $request->cookie('examClientIdentifier')
                ]);
                break;
            default:
                return $this->run(RespondWithJsonErrorJob::class);
        }
    }
}
