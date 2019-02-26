<?php


namespace Tests\Feature;


use App\Domains\Auth\Auth;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use TasksSeederRU;
use Tests\TestCase;

class ExamTest extends TestCase
{
    use DatabaseMigrations;

    const EMAIL = 'user@email';

    public function setUp()
    {
        parent::setUp();

        $this->app->make('config')->set('mail.driver', 'log');
    }

    public function testRun()
    {
        $this->databaseMigrations();

        $this->createUser();
        $this->authorization();
        $this->startExamSession();
        $this->checkExamStatus();
        $this->getTask();
        $this->saveAnswer();
        $this->finishExam();
    }

    private function databaseMigrations()
    {
        $this->runDatabaseMigrations();
        $this->seed(TasksSeederRU::class);
    }

    private function authorization()
    {
        Auth::deleteAuthUser();
        Auth::authorizeByEmail(self::EMAIL);
    }

    private function startExamSession()
    {
        $this->withoutMiddleware();
        $response = $this->post(route('start'));

        $this->assertEquals(200, $response->status());
    }

    private function createUser()
    {
        $user = new User(['email' => self::EMAIL]);
        $user->save();
    }

    private function checkExamStatus()
    {
        $this->withoutMiddleware();
        $response = $this->get(route('status'));
        $this->printTestResponse($response->content());
    }

    private function getTask()
    {
        $this->withoutMiddleware();
        $response = $this->get(route('task'));
        $this->assertEquals(200, $response->status());
        $this->printTestResponse($response->content());
    }

    private function saveAnswer()
    {
        $this->withoutMiddleware();
        $response = $this->call('POST', route('answer'), [
            'action' =>  'testCode',
            'taskNumber' => 0,
            'lang' => 'js'
        ]);

        $this->assertEquals(200, $response->status());
        $this->printTestResponse($response->content());
    }

    private function finishExam()
    {
        $this->withoutMiddleware();
        $response = $this->post(route('finish'));
        $this->assertEquals(200, $response->status());
        $this->printTestResponse($response->content());
    }
}
