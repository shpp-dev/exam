<?php
namespace App\Domains\Http\Traits;


use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

trait SendRequestTrait
{
    protected function sendCodeToCoderunner(string $coderunnerUrl, array $data)
    {
        $client = new Client();
        $response = $client->post($coderunnerUrl, [
            RequestOptions::JSON => $data
        ]);
        $responseContent = $response->getBody();

        return $responseContent;
    }
}
