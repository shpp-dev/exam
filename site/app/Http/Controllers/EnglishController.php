<?php


namespace App\Http\Controllers;

use App\Data\ExamSystem;
use App\Features\Exam\English\GetEnglishQuestionFeature;
use App\Features\Exam\English\SaveEnglishAnswerFeature;
use App\Features\Exam\Session\FinishExamFeature;
use App\Features\Exam\Session\StartExamFeature;
use Lucid\Foundation\Http\Controller as Controller;

class EnglishController extends Controller
{
    public function start()
    {
        return $this->serve(StartExamFeature::class, ['examName' => ExamSystem::ENGLISH_EXAM_NAME]);
    }

    public function getQuestion()
    {
        return $this->serve(GetEnglishQuestionFeature::class);
    }

    public function saveAnswer()
    {
        return $this->serve(SaveEnglishAnswerFeature::class);
    }

    public function finish()
    {
        $this->serve(FinishExamFeature::class, ['examName' => ExamSystem::ENGLISH_EXAM_NAME]);
    }
}
