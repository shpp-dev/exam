<?php

namespace App\Domains\Helpers\Jobs;


use Lucid\Foundation\Job;

class GenerateRandomStringJob extends Job
{
    const AVAILABLE_CHARS = '0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';

    protected $length;

    public function __construct(int $length = 8)
    {
        $this->length = $length;
    }

    public function handle()
    {
        $charactersLength = strlen(self::AVAILABLE_CHARS);
        $randomString = '';
        for ($i = 0; $i < $this->length; $i++) {
            $randomString .= self::AVAILABLE_CHARS[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
