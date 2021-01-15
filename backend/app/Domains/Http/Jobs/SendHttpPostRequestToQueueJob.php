<?php


namespace App\Domains\Http\Jobs;


use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Lucid\Foundation\Job;

class SendHttpPostRequestToQueueJob extends Job implements ShouldQueue
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

        $client->request('POST', $this->url, [
            'body' => json_encode($this->data)
        ]);
    }
}
