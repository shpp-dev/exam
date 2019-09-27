<?php

namespace App\Console\Commands;

use App\Features\User\ClearRegDataForUsersWhoMissedExamFeature;
use Illuminate\Console\Command;
use Lucid\Foundation\ServesFeaturesTrait;

class ClearExamRegistration extends Command
{
    use ServesFeaturesTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exam:registration-clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $this->serve(ClearRegDataForUsersWhoMissedExamFeature::class);
    }
}
