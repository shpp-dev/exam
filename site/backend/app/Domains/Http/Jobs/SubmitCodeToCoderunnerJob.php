<?php
namespace App\Domains\Http\Jobs;

use App\Domains\Helpers\Traits\JsonTrait;
use App\Domains\Http\Traits\SendRequestTrait;
use App\ProgrammingTask;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Job;

class SubmitCodeToCoderunnerJob extends Job
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
     * @var string
     */
    private $userFunction;

    /**
     * SubmitCodeToCoderunnerJob constructor.
     * @param ProgrammingTask $task
     * @param string $program
     * @param string $lang
     * @param string $userFunction
     */
    public function __construct(ProgrammingTask $task, string $program, string $lang, string $userFunction)
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

        try {
            $response = $this->sendCodeToCoderunner($this->coderunnerUrl, $testPack);

            if ($response == '' || property_exists(json_decode($response), 'error')) {
                Log::error('Coderunner not responding');
                return [];
            }

            $answers = explode('\ ', $this->task->answers);
            $stdOut = json_decode($response)->response->stdout;
            $resultCases = [];

            for ($i = 0; $i < count($answers); $i++) {
                // лечение отсутствия реакции страницы в случае отправки пустого массива при ретурна указателя
                if (count($stdOut) == 0) {
                    $resultCases[] = false;
                } else {
                    $resultCases[] = $answers[$i] == trim(preg_replace('/\s\s+/', ' ', $stdOut[$i]));
                }
            }

            return $resultCases;
        } catch (Exception $e) {
            Log::error($e);
            return [];
        }
    }
}
