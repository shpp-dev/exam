<?php

namespace App\Features\Exam;

use App\Domains\Auth\Auth;
use App\Domains\Exam\Jobs\CreateExamResultJob;
use App\Domains\Helpers\Traits\JsonTrait;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Domains\Http\Jobs\SendTestCodeToCoderunnerJob;
use App\Domains\Http\Jobs\SubmitCodeToCoderunnerJob;
use App\Task;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;
use Lucid\Foundation\ServesFeaturesTrait;

class SaveAnswerFeature extends Feature
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

        if ($session->results()->whereTaskNumber($taskNumber)->first()) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'message' => 'Nice try but you should not submit you solution twice',
                'code' => 420
            ]);
        }

        $selectedTasks = json_decode($session->tasksIds, true);
        $task = Task::find($selectedTasks[$taskNumber]);

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
                break;
            case 'submit':
                $result = $this->run(SubmitCodeToCoderunnerJob::class, [
                    'task' => $task,
                    'program' => $program,
                    'lang' => $lang,
                    'userFunction' => $userFunction
                ]);
                $this->run(CreateExamResultJob::class, [
                    'sessionId' => $session->id,
                    'task' => $task,
                    'result' => $result
                ]);
                if ($taskNumber == config('ptp.tasksOnExam')) {
                    $result['finished'] = true;
                    $this->serve(FinishExamFeature::class);
                } else {
                    $result['finished'] = false;
                }
                break;
        }

        return $this->run(RespondWithJsonJob::class, [
            'content' => $result
        ]);
    }
}
