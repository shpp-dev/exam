<?php

namespace App\Domains\Exam\Session\Jobs;


use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Lucid\Foundation\Job;

class FinishExamSessionsJob extends Job
{
    /**
     * @var Collection
     */
    private $sessions;

    public function __construct(Collection $sessions)
    {
        $this->sessions = $sessions;
    }

    public function handle()
    {
        DB::beginTransaction();

        foreach ($this->sessions as $session) {
            $session->finishedAt = Carbon::now();
            $session->save();
        }

        DB::commit();
    }
}
