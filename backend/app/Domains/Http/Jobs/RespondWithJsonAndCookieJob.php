<?php

namespace App\Domains\Http\Jobs;

use Lucid\Foundation\Job;
use Illuminate\Routing\ResponseFactory;

class RespondWithJsonAndCookieJob extends Job
{
    protected $status;
    protected $content;
    protected $cookie;

    public function __construct($cookie, $content = [], $status = 200)
    {
        $this->content = $content;
        $this->status = $status;
        $this->cookie = $cookie;
    }

    public function handle(ResponseFactory $factory)
    {
        $response = [
            'data' => $this->content,
            'status' => $this->status,
        ];

        return response()->json($response)
            ->withCookie(cookie($this->cookie['name'], $this->cookie['value'],
                $this->cookie['expiration'], $this->cookie['path'], $this->cookie['domain'], true, $httpOnly = true));
    }
}
