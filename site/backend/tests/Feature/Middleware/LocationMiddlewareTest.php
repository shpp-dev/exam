<?php


namespace Tests\Feature\Middleware;


use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\EverCookie;
use App\Location;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function testLocationWithOnlineExamSuccess()
    {
        config(['ptp.examOnline' => true]);

        $response = $this->get('/test/location');

        $response->assertStatus(200);
    }

    public function testLocationWithOfflineExamFailed()
    {
        config(['ptp.examOnline' => false]);

        $response = $this->get('/test/location');

        $response->assertStatus(400)
            ->assertJson([
                'error' => [
                    'message' => ExamSystem::CLIENT_NOT_IDENTIFIED,
                    'code' => 423
                ]
            ]);
    }

    public function testLocationWithOfflineExamSuccess()
    {
        factory(User::class)->create([
            'email' => 'test@email.com',
            'exam_datetime' => Carbon::now()->toDateTimeString(),
            'exam_location' => 'testAddress'
        ]);

        factory(Location::class)->create([
            'name' => 'testLocation',
            'address' => 'testAddress'
        ]);

        factory(EverCookie::class)->create([
            'location' => 'testLocation',
            'client' => 1,
            'token' => 'testToken'
        ]);

        Auth::authorizeByEmail('test@email.com');

        $response = $this->disableCookieEncryption()->withCookie('clientForExam', json_encode([
            'clientLocation' => 'testLocation',
            'clientId' => 1,
            'token' => 'testToken'
        ]))->get('test/location');

        $response->assertStatus(200);

    }
}
