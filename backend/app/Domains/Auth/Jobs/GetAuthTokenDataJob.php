<?php

namespace App\Domains\Helpers\Jobs;


use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Lucid\Foundation\Job;

class GetAuthTokenDataJob extends Job
{
    /**
     * @var string
     */
    private $authToken;

    /**
     * GetAuthTokenDataJob constructor.
     * @param string $authToken
     */
    public function __construct(string $authToken)
    {
        $this->authToken = $authToken;
    }

    /**
     * @return array
     */
    public function handle()
    {
        $authTokenData = null;
        $errorMessage = null;
        try {
            $authTokenData = JWT::decode(
                $this->authToken,
                openssl_pkey_get_public('file://'.config('auth.rsa')['public']),
                ['RS256']
            );
        } catch (SignatureInvalidException $e) {
            $errorMessage = 'The signature verification failed';
        } catch (BeforeValidException $e) {
            $errorMessage = 'Not eligible';
        } catch (ExpiredException $e) {
            $errorMessage = 'Token expired';
        } catch (\UnexpectedValueException $e) {
            $errorMessage = 'Invalid token';
        } catch (\Exception $e) {
            $errorMessage = 'Bad token';
        }
        return [
            'data' => $authTokenData,
            'error' => $errorMessage
        ];
    }
}
