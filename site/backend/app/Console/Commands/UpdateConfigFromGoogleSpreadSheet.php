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
        $envMap = $this->getEnvironmentsMap();

        foreach ($config as $field) {
            $envMap[$field['key']] = $field['value'];
        }

        $this->saveEnvironmentsMap($envMap);

        Artisan::call('config:cache');
    }

    private function getEnvironmentsMap(): array
    {
        $environments = file_get_contents(base_path('.env'));
        $envAsArray = explode("\n", $environments);
        $envMap = [];

        foreach ($envAsArray as $field) {
            if ($field) {
                $keyValue = explode('=', $field);
                $key = array_shift($keyValue);
                $envMap[$key] = implode('=', $keyValue);
            }
        }

        return $envMap;
    }

    private function saveEnvironmentsMap(array $envMap)
    {
        $preparedEnvironments = [];

        foreach ($envMap as $key => $value) {
            $preparedEnvironments[] = $key . '=' . $value;
        }

        file_put_contents(base_path('.env'), implode("\n", $preparedEnvironments));
    }
}
