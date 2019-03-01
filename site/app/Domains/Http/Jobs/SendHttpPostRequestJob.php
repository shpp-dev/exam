<?php
namespace App\Domains\Http\Jobs;

use GuzzleHttp\Client;
use Lucid\Foundation\Job;

class SendHttpPostRequestJob extends Job
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $data;

    /**
     * Create a new job instance.
     *
     * @param string $url
     * @param array $data
     */
    public function __construct(string $url, array $data)
    {
        $this->url = $url;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     */
    public function handle()
    {
        $client = new Client();
        $fullUrl = $this->url.'?';
        foreach ($this->data as $key => $value) {
            $fullUrl .= "$key=$value&";
        }
        return $client->post($fullUrl);
    }
}
