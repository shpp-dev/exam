<?php


namespace App\Http\Controllers;

use App\Data\ExamSystem;
use App\Features\Exam\Programming\GetProgrammingTaskFeature;
use App\Features\Exam\Programming\SaveProgrammingAnswerFeature;
use App\Features\Exam\Session\StartExamFeature;
use App\Features\Exam\Session\FinishExamFeature;
use Lucid\Foundation\Http\Controller as Controller;


class ProgrammingController extends Controller
{
    public function start()
    {
        $this->serve(StartExamFeature::class, ['examName' => ExamSystem::PROGRAMMING_EXAM_NAME]);
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
        $this->serve(FinishExamFeature::class, ['examName' => ExamSystem::PROGRAMMING_EXAM_NAME]);
    }
}
