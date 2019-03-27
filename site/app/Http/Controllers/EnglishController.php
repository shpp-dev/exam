<?php


namespace App\Http\Controllers;

use App\Features\Exam\English\GetQuestionFeature;
use App\Features\Exam\English\GetScoreFeature;
use App\Features\Exam\English\SaveAnswerFeature;
use Lucid\Foundation\Http\Controller as Controller;

class EnglishController extends Controller
{
    public function getQuestion()
    {
        return $this->serve(GetQuestionFeature::class);
    }

    public function saveAnswer()
    {
        return $this->serve(SaveAnswerFeature::class);
    }
}
