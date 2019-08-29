<?php


namespace App\Features\Admin;


use App\Domains\Auth\Jobs\RemoveEverCookieJob;
use App\Domains\Auth\Jobs\UpdateEverCookieJob;
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
        switch ($this->action) {
            case 'save':
                $this->run(UpdateEverCookieJob::class, [
                    'newClientId' => $request->clientId,
                    'oldClientId' => $request->cookie('clientId')
                ]);
                break;
            case 'remove':
                $this->run(RemoveEverCookieJob::class, [
                    'clientId' => $request->cookie('clientId')
                ]);
                break;
            default:
                return $this->run(RespondWithJsonErrorJob::class);
        }
    }
}
