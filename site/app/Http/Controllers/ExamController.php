<?php

namespace App\Http\Controllers;

use App\Features\Exam\CheckExamStatusFeature;
use App\Features\Exam\FinishExamFeature;
use App\Features\Exam\GetTaskFeature;
use App\Features\Exam\SaveAnswerFeature;
use App\Features\Exam\StartExamSessionFeature;
use Illuminate\Http\Request;

class ExamController extends \Lucid\Foundation\Http\Controller
{
    public function getStatus()
    {
        $this->serve(CheckExamStatusFeature::class);
    }

    public function startSession()
    {
        $this->serve(StartExamSessionFeature::class);
    }

    public function getTask()
    {
        $this->serve(GetTaskFeature::class);
    }

    public function saveAnswer()
    {
        $this->serve(SaveAnswerFeature::class);
    }

    public function finishExam()
    {
        $this->serve(FinishExamFeature::class);
    }
}
