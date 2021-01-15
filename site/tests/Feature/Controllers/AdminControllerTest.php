<?php


namespace Tests\Feature\Controllers;


use App\ExamSession;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    private $uncheckedCount = 2;
    private $passedCount = 3;
    private $failedCount = 4;

    protected function setUp(): void
    {
        parent::setUp();

        $user = factory(User::class)->create();
        factory(ExamSession::class, $this->uncheckedCount)->create(['user_id' => $user->id, 'passed' => null]);
        factory(ExamSession::class, $this->passedCount)->create(['user_id' => $user->id, 'passed' => true]);
        factory(ExamSession::class, $this->failedCount)->create(['user_id' => $user->id, 'passed' => false]);
    }

    public function testGetAllUsersExams()
    {
        $response = $this->withoutMiddleware()->get('admin/list/all');

        $response->assertStatus(200)
            ->assertJsonCount($this->uncheckedCount + $this->passedCount + $this->failedCount, 'data.exams');
    }

    public function testGetUncheckedUsersExams()
    {
        $response = $this->withoutMiddleware()->get('admin/list/unchecked');

        $response->assertStatus(200)
            ->assertJsonCount($this->uncheckedCount, 'data.exams');
    }

    public function testGetPassedUsersExams()
    {
        $response = $this->withoutMiddleware()->get('admin/list/passed');

        $response->assertStatus(200)
            ->assertJsonCount($this->passedCount, 'data.exams');
    }

    public function testGetFailedUsersExams()
    {
        $response = $this->withoutMiddleware()->get('admin/list/failed');

        $response->assertStatus(200)
            ->assertJsonCount($this->failedCount, 'data.exams');
    }

    public function testCheckExamForUser()
    {
        $response = $this->withoutMiddleware()->post('admin/check', [

        ]);

        $response->assertStatus(200);
    }

    public function testEverCookieForClient()
    {

    }

    public function testDisableCheckingLocation()
    {

    }

}
