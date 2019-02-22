<?php
namespace App\Domains\Http\Jobs;

use App\Domains\Helpers\Traits\JsonTrait;
use App\Domains\Http\Traits\SendRequestTrait;
use App\Task;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Lucid\Foundation\Job;

class SubmitCodeToCoderunnerJob extends Job
{
    use SendRequestTrait, JsonTrait;

    /**
     * @var string
     */
    private $coderunnerUrl;

    /**
     * @var Task
     */
    private $task;

    /**
     * @var string
     */
    private $program;

    /**
     * @var string
     */
    private $lang;

    /**
     * @var string
     */
    private $userFunction;

    /**
     * SubmitCodeToCoderunnerJob constructor.
     * @param Task $task
     * @param string $program
     * @param string $lang
     * @param string $userFunction
     */
    public function __construct(Task $task, string $program, string $lang, string $userFunction)
    {
        $this->coderunnerUrl = config('ptp.coderunnerUrl');
        $this->task = $task;
        $this->program = $program;
        $this->lang = $lang;
        $this->userFunction = $userFunction;
    }

    public function handle()
    {
        $testCases = explode(',', $this->task->testCases);

        $testPack = [
            'userName' => 'testuser',
            'serverSecret' => config('ptp.coderunnerKey'),
            'code' => $this->program,
            'language' => $this->lang,
            'testCases' => $testCases
        ];
        $response = $this->sendCodeToCoderunner($this->coderunnerUrl, $testPack);

        if ($response == '' || property_exists(json_decode($response), 'error')) {
            return [
                'error' => true,
                'message' => 'Наш кодераннер отключен :( <br>Пожалуйста, свяжитесь с администрацией.',
                'code' => 503
            ];
        }
        $answers = explode('\ ', $this->task->answers);
        $stdOut = json_decode($response)->response->stdout;
        $cases = 0;
        $resultCases = [];

        for ($i = 0; $i < count($answers); $i++) {
            // лечение отсутствия реакции страницы в случае отправки пустого массива при ретурна указателя
            if (count($stdOut) == 0) {
                return [
                    'error' => true,
                    'message' => 'Допущена ошибка запуска скрипта :( <br>Отправьте код на тестирование для получения деталей',
                    'code' => 500
                ];
            }
            if ($answers[$i] == trim(preg_replace('/\s\s+/', ' ', $stdOut[$i]))) {
                $resultCases[$i] = true;
                $cases++;
            } else {
                $resultCases[$i] = false;
            }
        }

        $result = [
            'userFunction' => trim($this->escapeJsonString($this->userFunction)),
            'passedCases' => $cases,
            'resultCases' => $resultCases
        ];

        return $result;
    }
}
