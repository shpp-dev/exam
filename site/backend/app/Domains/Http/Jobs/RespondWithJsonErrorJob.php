<?php

namespace App\Domains\Http\Jobs;

use Illuminate\Routing\ResponseFactory;

class RespondWithJsonErrorJob extends RespondWithJsonJob
{
    public function __construct($message = 'An error occurred', $code = 400, $status = 400, $headers = [], $options = 0, $data = [])
    {
        $this->content = [
            'status' => $status,
            'error' => [
                'code' => $code,
                'message' => $message,
            ],
            'data' => $data
        ];

        $this->status = $status;
        $this->headers = $headers;
        $this->options = $options;
    }

    public function handle(ResponseFactory $response)
    {
        return $response->json($this->content, $this->status, $this->headers, $this->options);
    }
}
