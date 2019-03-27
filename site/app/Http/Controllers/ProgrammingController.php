<?php


namespace App\Http\Controllers;

use App\Features\Exam\Programming\GetTaskFeature;
use App\Features\Exam\Programming\SaveAnswerFeature;
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
