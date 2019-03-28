<?php


namespace App\Http\Controllers;

use App\Features\Exam\Session\CheckExamAllowedStatusFeature;
use App\Features\Exam\Session\FinishSessionFeature;
use App\Features\Exam\Session\GetPreparedExamsListFeature;
use App\Features\Exam\Session\StartSessionFeature;
use Lucid\Foundation\Http\Controller as Controller;

class ExamSessionController extends Controller
{
    public function status()
    {
        return $this->serve(CheckExamAllowedStatusFeature::class);
    }

    public function start()
    {
        return $this->serve(StartSessionFeature::class);
    }

    public function examsList()
    {
        return $this->serve(GetPreparedExamsListFeature::class);
    }

    public function finish()
    {
        return $this->serve(FinishSessionFeature::class);
    }
}
