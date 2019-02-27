<?php

namespace App\Console\Commands;

use App\ExamSession;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FinishExamSession extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exam:finish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Forced finish exam session after deadline';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        ExamSession::where('finished_at', null)
                   ->where('started_at', '<', Carbon::now()->subMinutes(config('ptp.examDurationMins')))
                   ->update(['finished_at' => Carbon::now()]);
    }
}
