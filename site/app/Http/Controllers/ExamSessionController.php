<?php


namespace App\Http\Controllers;

use App\Features\Exam\CheckExamAllowedStatusFeature;
use App\Features\Exam\FinishExamSessionFeature;
use App\Features\Exam\StartExamSessionFeature;
use Lucid\Foundation\Http\Controller as Controller;

class ExamSessionController extends Controller
{
    public function status()
    {
        return $this->serve(CheckExamAllowedStatusFeature::class);
    }

    public function start()
    {
        return $this->serve(StartExamSessionFeature::class);
    }

    public function finish()
    {
        return $this->serve(FinishExamSessionFeature::class);
    }
}
