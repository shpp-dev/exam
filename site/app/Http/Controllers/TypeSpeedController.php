<?php


namespace App\Http\Controllers;

use App\Data\ExamSystem;
use App\Features\Exam\Session\StartExamFeature;
use App\Features\Exam\TypeSpeed\SaveTypeSpeedFeature;
use Lucid\Foundation\Http\Controller as Controller;


class TypeSpeedController extends Controller
{
    public function start()
    {
        return $this->serve(StartExamFeature::class, ['examName' => ExamSystem::TYPE_SPEED_EXAM_NAME]);
    }

    public function saveResult()
    {
        return $this->serve(SaveTypeSpeedFeature::class);
    }
}
