<?php


namespace App\Http\Controllers;

use App\Data\ExamSystem;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Features\Exam\English\GetEnglishQuestionFeature;
use App\Features\Exam\English\SaveEnglishAnswerFeature;
use App\Features\Exam\Session\FinishExamFeature;
use App\Features\Exam\Session\GetRestOfExamTimeFeature;
use App\Features\Exam\Session\StartExamFeature;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Lucid\Foundation\Http\Controller as Controller;
use Lucid\Foundation\JobDispatcherTrait;
use Lucid\Foundation\MarshalTrait;

class EnglishController extends Controller
{
    use MarshalTrait;
    use DispatchesJobs;
    use JobDispatcherTrait;

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
        $finished = $this->serve(FinishExamFeature::class, ['examName' => ExamSystem::ENGLISH_EXAM_NAME]);

        return $this->run(RespondWithJsonJob::class, [
            'content' => [
                'finished' => $finished
            ]
        ]);
    }

    public function remainingTime()
    {
        return $this->serve(GetRestOfExamTimeFeature::class, ['examType' => ExamSystem::ENGLISH_EXAM_NAME]);
    }
}
