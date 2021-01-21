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
        return $client->request('POST', $this->url, [
            'body' => json_encode($this->data)
        ]);
    }
}
