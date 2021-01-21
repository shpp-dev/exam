<?php


namespace Tests\Feature\Middleware;


use Tests\TestCase;

class EcosystemMiddlewareTest extends TestCase
{
    public function testEcosystemFailed()
    {
        $response = $this->get('test/ecosystem');

        $response->assertStatus(400)
            ->assertJson([
                'error' => [
                    'code' => 403
                ]
            ]);
    }

    public function testEcosystemSuccess()
    {
        config(['auth.eco' => '123']);
        $response = $this->get('test/ecosystem?eco=123');

        $response->assertStatus(200);
    }
}
