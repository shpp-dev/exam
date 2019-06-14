<?php

namespace App\Features\Exam\Programming;

use App\Data\ExamSystem;
use App\Domains\Auth\Auth;
use App\Domains\Exam\Programming\Jobs\CreateProgrammingResultJob;
use App\Domains\Exam\Session\Jobs\CheckFinishedExamJob;
use App\Domains\Helpers\Traits\JsonTrait;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\SendTestCodeToCoderunnerJob;
use App\Domains\Http\Jobs\SubmitCodeToCoderunnerJob;
use App\Features\Exam\Session\FinishExamFeature;
use App\ProgrammingTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Lucid\Foundation\Feature;
use Lucid\Foundation\ServesFeaturesTrait;

class SaveProgrammingAnswerFeature extends Feature
{
    use JsonTrait, ServesFeaturesTrait;

    public function handle(Request $request)
    {
        $user = Auth::getAuthUser();
        $session = $user->activeSession();

        $action = $request->action;
        $taskNumber = $request->taskNumber;// start from 0 index
        $lang = $request->lang; // js cpp java
        $userFunction = $request->userFunction;

        $isFinished = $this->run(CheckFinishedExamJob::class, [
            'session' => $session,
            'examName' => ExamSystem::PROGRAMMING_EXAM_NAME
        ]);

        if ($isFinished) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => ExamSystem::EXAM_WAS_FINISHED
            ]);
        }

        if ($session->programmingResults()->whereTaskNumber($taskNumber)->first()) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Nice try but you should not submit you solution twice',
                'code' => 420
            ]);
        }

        $selectedTasks = json_decode($session->programmingTasksIds, true);
        $task = ProgrammingTask::find($selectedTasks[$taskNumber]);

        $program = [];
        switch ($lang) {
            case 'java':
                $program = str_replace('{{code}}', $userFunction, $task->javaWrap);
                break;
            case 'js':
                $program = str_replace('{{code}}', $userFunction, $task->jsWrap);
                break;
            case 'cpp':
                $program = str_replace('{{code}}', $userFunction, $task->cppWrap);
                break;
        }

        $result = [];
        switch ($action) {
            case 'test':
                $result = $this->run(SendTestCodeToCoderunnerJob::class, [
                    'task' => $task,
                    'program' => $program,
                    'lang' => $lang
                ]);

                Log::info('User '.$user->id.' sent for testing solution for task '.$task->id);
                break;
            case 'submit':
                $result = $this->run(SubmitCodeToCoderunnerJob::class, [
                    'task' => $task,
                    'program' => $program,
                    'lang' => $lang,
                    'userFunction' => $userFunction
                ]);

                $this->run(CreateProgrammingResultJob::class, [
                    'sessionId' => $session->id,
                    'task' => $task,
                    'result' => [
                        'userFunction' => $userFunction,
                        'resultCases' => $result['resultCases'] ?? []
                    ]
                ]);

                Log::info('User '.$user->id.' submit solution for task '.$task->id);
                break;
        }

        if ($action == 'submit' && $taskNumber == config('ptp.programmingTasksAmount')) {
            $result['finished'] = $this->run(FinishExamFeature::class, [
                'session' => $session,
                'examName' => ExamSystem::PROGRAMMING_EXAM_NAME
            ]);
        } else {
            $result['finished'] = [
                'programming' => false,
                'session' => false
            ];
        }

        return $this->run(RespondWithJsonJob::class, [
            'content' => $result
        ]);
    }
}
