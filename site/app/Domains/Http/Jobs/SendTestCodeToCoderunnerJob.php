<?php
namespace App\Domains\Http\Jobs;

use App\Domains\Helpers\Traits\JsonTrait;
use App\Domains\Http\Traits\SendRequestTrait;
use App\ProgrammingTask;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Job;

class SendTestCodeToCoderunnerJob extends Job
{
    use SendRequestTrait, JsonTrait;

    /**
     * @var string
     */
    private $coderunnerUrl;

    /**
     * @var ProgrammingTask
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
     * SendTestCodeToCoderunnerJob constructor.
     * @param ProgrammingTask $task
     * @param string $program
     * @param string $lang
     */
    public function __construct(ProgrammingTask $task, string $program, string $lang)
    {
        $this->coderunnerUrl = config('ptp.coderunnerUrl');
        $this->task = $task;
        $this->program = $program;
        $this->lang = $lang;
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

        try {
            $response = json_decode($this->sendCodeToCoderunner($this->coderunnerUrl, $testPack));

            if ($response == '' || property_exists($response, 'error')) {
                return [
                    'error' => true,
                    'message' => 'При тестуванні коду щось пішло не так. Але ви все одно можете завантажити своє рішення',
                    'code' => 500
                ];
            }

            if ($response->code != 200) {
                Log::error(json_encode($response));
                return [
                    'error' => true,
                    'message' => 'При тестуванні коду щось пішло не так. Але ви все одно можете завантажити своє рішення',
                    'code' => 500
                ];
            }

            if ($response->response->compilerErrors || $response->response->stderr[0] != '') {
                return [
                    'error' => true,
                    'message' => 'Помилка при тестуванні. Вам потрібно внести якісь зміни у свій код',
                    'code' => 418
                ];
            }

            if (empty($response->response->stdout) && empty($response->response->stderr)) {
                return [
                    'error' => true,
                    'message' => 'При тестуванні коду щось пішло не так. Але ви все одно можете завантажити своє рішення',
                    'code' => 500
                ];
            }

            $answers = explode('\ ', $this->task->answers);
            $stdOut = $response->response->stdout;
            $resultCases = [];

            for ($i = 0; $i < count($stdOut); $i++) {
                $resultCases[] = $answers[$i] == trim(preg_replace('/\s\s+/', ' ', $stdOut[$i]));
            }

            return [
                'error' => false,
                'resultCases' => $resultCases
            ];
        } catch (\Exception $e) {
            Log::error($e);
            return [
                'error' => true,
                'message' => 'При тестуванні коду щось пішло не так. Але ви все одно можете завантажити своє рішення',
                'code' => 500
            ];
        }
    }
}
