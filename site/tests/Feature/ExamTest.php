<?php


namespace Tests\Feature;


use App\Domains\Auth\Auth;
use App\ExamSession;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use TasksSeederRU;
use TasksSeederTest;
use Tests\TestCase;

class ExamTest extends TestCase
{
    use DatabaseMigrations;

    const EMAIL = 'user@email';
    const LANG = 'cpp';
    const PROGRAMMING_TASKS_NUM = 6;
    const ENGLISH_TASKS_NUM = 25;
    const TASK_KEYS = [4,1,11,15,20,2];
    const SEEDER = TasksSeederTest::class;

    private $examTasks;
    private $testNumber;

    public function setUp(): void
    {
        parent::setUp();

        $this->testNumber = 0;
        $this->examTasks = json_decode(file_get_contents(storage_path('/app/exam/programmingAnswers.json')), true);
        $this->app->make('config')->set('mail.driver', 'log');
    }

    public function testRun()
    {
        $this->databaseMigrations();

        $this->createUser();
        $this->authorization();
        $this->startExamSession();
        $this->checkExamStatus();
        $this->getExamsList();

        for ($i = 0; $i < self::PROGRAMMING_TASKS_NUM; $i++) {
            $taskNumber = $this->getProgrammingTask();
            $this->saveProgrammingAnswer($taskNumber, self::LANG, $this->examTasks[self::TASK_KEYS[$i]][self::LANG]);
        }

        $this->getExamsList();

        for ($i = 0; $i < self::ENGLISH_TASKS_NUM; $i++) {
            $this->getEnglishQuestion();
            $this->saveEnglishAnswer($i + 1);
        }

        $this->getExamsList();

        $this->startTypeExam();
        $this->saveTypeSpeedExam();

        $this->getUncheckedUsersData();
    }

    private function databaseMigrations()
    {
        $this->printTestHeader(++$this->testNumber, __FUNCTION__);
        $this->runDatabaseMigrations();
        $this->seed(self::SEEDER);
    }

    private function authorization()
    {
        $this->printTestHeader(++$this->testNumber, __FUNCTION__);
        Auth::deleteAuthUser();
        Auth::authorizeByEmail(self::EMAIL);
    }

    private function startProgrammingExam()
    {
        $this->printTestHeader(++$this->testNumber, __FUNCTION__);
        $this->withoutMiddleware();
        $response = $this->post(route('programmingStart'));
        $this->tasks = ExamSession::find(1)->programmingTasksIds;
        $this->assertEquals(200, $response->status());
        $this->printTestResponse($response->content());
        $this->printDatabaseTable('exam_sessions');
    }

    private function createUser()
    {
        $this->printTestHeader(++$this->testNumber, __FUNCTION__);
        $user = new User(['email' => self::EMAIL]);
        $user->save();
    }

    private function checkExamStatus()
    {
        $this->printTestHeader(++$this->testNumber, __FUNCTION__);
        $this->withoutMiddleware();
        $response = $this->get(route('status'));
        $this->printTestResponse($response->content());
    }

    private function getProgrammingTask()
    {
        $this->printTestHeader(++$this->testNumber, __FUNCTION__);
        $this->withoutMiddleware();
        $response = $this->get(route('programmingTask'));

        $this->printTestResponse($response->content());
        $this->assertEquals(200, $response->status());

        return json_decode($response->content(), true)['data']['number'];
    }

    private function saveProgrammingAnswer($taskNumber, $lang, $function)
    {
        $this->printTestHeader(++$this->testNumber, __FUNCTION__);
        $this->withoutMiddleware();
        $response = $this->call('POST', route('programmingAnswer'), [
            'action' =>  'submit',
            'taskNumber' => $taskNumber,
            'lang' => $lang,
            'userFunction' => $function
        ]);

        $this->assertEquals(200, $response->status());
        $this->printTestResponse($response->content());
        $this->printDatabaseTable('programming_results');
    }

    private function finishProgrammingExam()
    {
        $this->printTestHeader(++$this->testNumber, __FUNCTION__);
        $this->withoutMiddleware();
        $response = $this->post(route('programmingFinish'));
        $this->assertEquals(200, $response->status());
        $this->printTestResponse($response->content());
        $this->printDatabaseTable('exam_sessions');
    }

    private function startExamSession()
    {
        $this->printTestHeader(++$this->testNumber, __FUNCTION__);
        $this->withoutMiddleware();
        $response = $this->post(route('start'));
        $this->assertEquals(200, $response->status());
        $this->printTestResponse($response->content());
        $this->printDatabaseTable('exam_sessions');
    }

    private function startEnglishExam()
    {
        $this->printTestHeader(++$this->testNumber, __FUNCTION__);
        $this->withoutMiddleware();
        $response = $this->post(route('englishStart'));
        $this->assertEquals(200, $response->status());
        $this->printTestResponse($response->content());
        $this->printDatabaseTable('exam_sessions');
    }

    private function getEnglishQuestion()
    {
        $this->printTestHeader(++$this->testNumber, __FUNCTION__);
        $this->withoutMiddleware();
        $response = $this->get(route('englishQuestion'));
        $this->assertEquals(200, $response->status());
        $this->printTestResponse($response->content());
    }

    private function saveEnglishAnswer($taskNumber)
    {
        $this->printTestHeader(++$this->testNumber, __FUNCTION__);
        $this->withoutMiddleware();
        $response = $this->call('POST', route('englishAnswer'), [
            'taskNumber' => $taskNumber,
            'answer' => '4'
        ]);
        $this->assertEquals(200, $response->status());
        $this->printTestResponse($response->content());
    }

    private function saveTypeSpeedExam()
    {
        $this->printTestHeader(++$this->testNumber, __FUNCTION__);
        $this->withoutMiddleware();
        $response = $this->call('POST', route('typeSpeed'), [
            'speed' => '170',
            'accuracy' => '94.5'
        ]);
        $this->assertEquals(200, $response->status());
        $this->printTestResponse($response->content());
    }

    private function startTypeExam()
    {
        $this->printTestHeader(++$this->testNumber, __FUNCTION__);
        $this->withoutMiddleware();
        $response = $this->post(route('typeStart'));
        $this->assertEquals(200, $response->status());
        $this->printTestResponse($response->content());
    }

    private function getExamsList()
    {
        $this->printTestHeader(++$this->testNumber, __FUNCTION__);
        $this->withoutMiddleware();
        $response = $this->get(route('examsList'));
        $this->assertEquals(200, $response->status());
        $this->printTestResponse($response->content());
    }

    private function getUncheckedUsersData()
    {
        $this->printTestHeader(++$this->testNumber, __FUNCTION__);
        $this->withoutMiddleware();
        $response = $this->get(route('uncheckedList'));
        $this->assertEquals(200, $response->status());
        $this->printTestResponse($response->content());
    }
}
