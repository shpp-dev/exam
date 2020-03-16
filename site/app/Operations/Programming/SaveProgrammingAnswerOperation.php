<?php


namespace App\Operations;


use App\Domains\Exam\Programming\Jobs\CreateProgrammingResultJob;
use App\Domains\Http\Jobs\SubmitCodeToCoderunnerJob;
use App\ProgrammingTask;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Operation;

class SaveProgrammingAnswerOperation extends Operation implements ShouldQueue
{
    /**
     * @var int
     */
    private $userId;

    /**
     * @var int
     */
    private $sessionId;

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
     * SaveProgrammingAnswerOperation constructor.
     * @param int $userId
     * @param int $sessionId
     * @param ProgrammingTask $task
     * @param string $program
     * @param string $lang
     * @param string $userFunction
     */
    public function __construct(
        int $userId,
        int $sessionId,
        ProgrammingTask $task,
        string $program,
        string $lang,
        string $userFunction
    ) {
        $this->userId = $userId;
        $this->sessionId = $sessionId;
        $this->task = $task;
        $this->program = $program;
        $this->lang = $lang;
        $this->userFunction = $userFunction;
    }

    public function handle()
    {
        $resultCases = $this->run(SubmitCodeToCoderunnerJob::class, [
            'task' => $this->task,
            'program' => $this->program,
            'lang' => $this->lang,
            'userFunction' => $this->userFunction
        ]);

        $this->run(CreateProgrammingResultJob::class, [
            'sessionId' => $this->sessionId,
            'task' => $this->task,
            'result' => [
                'userFunction' => $this->userFunction,
                'resultCases' => $resultCases
            ]
        ]);

        Log::info('User ' . $this->userId . ' submit solution for task ' . $this->task->id);
    }
}
