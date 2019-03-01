<?php


namespace Tests\Feature;


use App\Domains\Auth\Auth;
use App\ExamSession;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use TasksSeederRU;
use TasksSeederTest;
use Tests\TestCase;

class ExamTest extends TestCase
{
    use DatabaseMigrations;

    const EMAIL = 'user@email';
    const LANG = 'js';
    const TASKS_NUM = 5;

    private $taskResolves;

    public function setUp()
    {
        parent::setUp();

//        $this->taskResolves = json_decode(file_get_contents(storage_path('test_function_resolves.json')), true);
        $this->app->make('config')->set('mail.driver', 'log');
    }

    public function testRun()
    {
        $this->databaseMigrations();

        $this->createUser();
        $this->authorization();
        $this->startExamSession();
        $this->checkExamStatus();

        do {
            $taskNumber = $this->getTask();
            $this->saveAnswer($taskNumber, self::LANG, $this->taskResolves[$taskNumber][self::LANG]);
        } while ($taskNumber < self::TASKS_NUM);

//        $this->finishExam();
    }

    private function databaseMigrations()
    {
        $this->runDatabaseMigrations();
        $this->seed(TasksSeederRu::class);
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
        $this->tasks = ExamSession::find(1)->tasksIds;
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

        return json_decode($response->content(), true)['data']['number'];
    }

    private function saveAnswer($taskNumber, $lang, $function)
    {
        $this->withoutMiddleware();
        $response = $this->call('POST', route('answer'), [
            'action' =>  'submit',
            'taskNumber' => $taskNumber,
            'lang' => $lang,
            'userFunction' => $function
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
