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
        $testCases = [$testCases[0], $testCases[1]];

        $testPack = [
            'userName' => 'testuser',
            'serverSecret' => config('ptp.coderunnerKey'),
            'code' => $this->program,
            'language' => $this->lang,
            'testCases' => $testCases
        ];
        $response = json_decode($this->sendCodeToCoderunner($this->coderunnerUrl, $testPack));

        if ($response == '' || property_exists($response, 'error')) {
            return [
                'error' => true,
                'message' => 'Наш кодераннер отключен. :( Пожалуйста, свяжитесь с администрацией.',
                'code' => 503
            ];
        }

        if ($response->code != 200) {
            Log::error(json_encode($response));
            return [
                'error' => true,
                'message' => 'Проблемы с кодраннером. :( Пожалуйста, свяжитесь с администрацией.',
                'code' => 500
            ];
        }

        if ($response->response->compilerErrors != '') {
            $errorLines = explode('\n', $this->escapeJsonString($response->response->compilerErrors));
            $trimmedErr = implode('\n', array_slice($errorLines, 0, 4));
            return [
                'error' => true,
                'message' => $trimmedErr,
                'code' => 418
            ];
        }

        if (empty($response->response->stdout) && empty($response->response->stderr)) {
            return [
                'error' => true,
                'message' => 'Проблемы с кодраннером. :( Пожалуйста, свяжитесь с администрацией.',
                'code' => 500
            ];
        }

        if ($response->response->stderr[0] != '') {
            return [
                'error' => true,
                'message' => 'Ваше решение несовместимо с жизнью. :) Вам нужно внести какие-то правки',
                'code' => 418
            ];
        }

        $answers = explode('\ ', $this->task->answers);
        $stdOut = $response->response->stdout;
        $cases = 0;
        $resultCases = [];
        for ($i = 0; $i < 2; $i++) {
            if ($answers[$i] == trim(preg_replace('/\s\s+/', ' ', $stdOut[$i]))) {
                $cases++;
                $resultCases[$i] = true;
            }
        }
        return [
            'error' => false,
            'resultCases' => $resultCases
        ];
    }
}
