<?php

namespace App\Http\Controllers;

use App\Features\Exam\CheckExamStatusFeature;
use App\Features\Exam\FinishExamFeature;
use App\Features\Exam\GetTaskFeature;
use App\Features\Exam\SaveAnswerFeature;
use App\Features\Exam\StartExamSessionFeature;
use Lucid\Foundation\Http\Controller as Controller;

class ExamController extends Controller
{
    public function getStatus()
    {
        return $this->serve(CheckExamStatusFeature::class);
    }

    public function startSession()
    {
        return $this->serve(StartExamSessionFeature::class);
    }

    public function getTask()
    {
        return $this->serve(GetTaskFeature::class);
    }

    public function saveAnswer()
    {
        return $this->serve(SaveAnswerFeature::class);
    }

    public function finishExam()
    {
        return $this->serve(FinishExamFeature::class);
    }
}
