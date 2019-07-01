<?php

namespace App\Features\Exam\TypeSpeed;

use App\Domains\Exam\TypeSpeed\Jobs\GetRandomTextJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;

class GetRandomTextFeature extends Feature
{
    public function handle()
    {
        $randomText = $this->run(GetRandomTextJob::class);

        return $this->run(RespondWithJsonJob::class, [
            'content' => [
                'randomText' => $randomText
            ]
        ]);
    }
}
