<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UpdateConfigFromGoogleSpreadSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptp:config-update';

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

    public function handle()
    {
        $config = $this->getConfigFromGoogleSpreadsheet();
        $this->updateConfig($config);
    }

    private function getConfigFromGoogleSpreadsheet()
    {
        $client = new Client();

        $client->get(config('services.sheets.invalidateConfigUrl'));
        $response = $client->post(config('services.sheets.configUrl'));

        return json_decode($response->getBody(), true)['data'];
    }

    private function updateConfig(array $config)
    {
        $environments = file_get_contents(base_path('.env'));

        foreach ($config as $field) {
            if (strpos($environments, $field['key']) === false) {
                file_put_contents(base_path('.env'), "\n" .  $field['key'] . '=' . $field['value'], FILE_APPEND);
            }
        }

        Artisan::call('config:cache');
    }
}
