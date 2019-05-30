<?php


namespace App\Http\Controllers;

use App\Data\ExamSystem;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Features\Exam\Programming\GetProgrammingTaskFeature;
use App\Features\Exam\Programming\SaveProgrammingAnswerFeature;
use App\Features\Exam\Session\StartExamFeature;
use App\Features\Exam\Session\FinishExamFeature;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Lucid\Foundation\Http\Controller as Controller;
use Lucid\Foundation\JobDispatcherTrait;
use Lucid\Foundation\MarshalTrait;


class ProgrammingController extends Controller
{
    use MarshalTrait;
    use DispatchesJobs;
    use JobDispatcherTrait;

    public function start()
    {
        return $this->serve(StartExamFeature::class, ['examName' => ExamSystem::PROGRAMMING_EXAM_NAME]);
    }

    public function getTask()
    {
        return $this->serve(GetProgrammingTaskFeature::class);
    }

    public function saveAnswer()
    {
        return $this->serve(SaveProgrammingAnswerFeature::class);
    }

    public function finish()
    {
        $finished = $this->serve(FinishExamFeature::class, ['examName' => ExamSystem::PROGRAMMING_EXAM_NAME]);

        return $this->run(RespondWithJsonJob::class, [
            'content' => [
                'finished' => $finished
            ]
        ]);
    }
}
