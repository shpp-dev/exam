<?php

namespace Tests\Feature\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationMiddlewareTest extends TestCase
{
    public function testAuthenticationFailed()
    {
        $response = $this->get('test/auth');

        $response
            ->assertStatus(400)
            ->assertJson([
                'error' => [
                    'message' => 'Non authorized',
                    'code' => 401
                ]
            ]);
    }
}
