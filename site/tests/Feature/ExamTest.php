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
    const LANG = 'cpp';
    const TASKS_NUM = 6;
    const TASK_KEYS = [4,1,11,15,20,2];
    const SEEDER = TasksSeederTest::class;

    private $examTasks;
    private $testNumber;

    public function setUp(): void
    {
        parent::setUp();

        $this->testNumber = 0;
        $this->examTasks = json_decode(file_get_contents(storage_path('exam_tasks.json')), true);
        $this->app->make('config')->set('mail.driver', 'log');
    }

    public function testRun()
    {
        $this->databaseMigrations();

        $this->createUser();
        $this->authorization();
        $this->startExamSession();
        $this->checkExamStatus();

        for ($i = 0; $i < self::TASKS_NUM; $i++) {
            $taskNumber = $this->getTask();
            $this->saveAnswer($taskNumber, self::LANG, $this->examTasks[self::TASK_KEYS[$i]][self::LANG]);
        }

//        $this->finishExam();
    }

    private function databaseMigrations()
    {
        $this->runDatabaseMigrations();
        $this->seed(self::SEEDER);
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
