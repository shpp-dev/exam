<?php


namespace App\Http\Controllers;

use App\Data\ExamSystem;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use App\Features\Exam\Session\StartExamFeature;
use App\Features\Exam\TypeSpeed\SaveTypeSpeedFeature;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Lucid\Foundation\Http\Controller as Controller;
use Lucid\Foundation\JobDispatcherTrait;
use Lucid\Foundation\MarshalTrait;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;


class TypeSpeedController extends Controller
{
    use MarshalTrait;
    use DispatchesJobs;
    use JobDispatcherTrait;

    public function start()
    {
        try {
            $this->serve(StartExamFeature::class, [
                'examName' => ExamSystem::TYPE_SPEED_EXAM_NAME
            ]);
        } catch (ConflictHttpException $e) {
            return $this->run(RespondWithJsonErrorJob::class, [
                'code' => 409,
                'message' => ExamSystem::CONCURRENT_EXAM_ERROR
            ]);
        }

        return $this->run(RespondWithJsonJob::class);
    }

    public function saveResult()
    {
        return $this->serve(SaveTypeSpeedFeature::class);
    }
}
