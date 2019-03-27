<?php


namespace App\Http\Controllers;

use App\Features\Exam\Session\CheckExamAllowedStatusFeature;
use App\Features\Exam\Session\FinishExamSessionFeature;
use App\Features\Exam\Session\StartExamSessionFeature;
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
