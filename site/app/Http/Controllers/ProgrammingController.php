<?php


namespace App\Http\Controllers;

use App\Features\Exam\GetTaskFeature;
use App\Features\Exam\SaveAnswerFeature;
use \Lucid\Foundation\Http\Controller as Controller;


class ProgrammingController extends Controller
{
    public function getTask()
    {
        return $this->serve(GetTaskFeature::class);
    }

    public function saveAnswer()
    {
        return $this->serve(SaveAnswerFeature::class);
    }
}
