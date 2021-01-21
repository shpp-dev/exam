<?php


namespace App\Domains\Exam\TypeSpeed\Jobs;


use App\ExamSession;
use App\TypeSpeedResult;
use Lucid\Foundation\Job;

class CreateTypeSpeedResultJob extends Job
{
    private $session;
    private $speed;
    private $accuracy;

    public function __construct(ExamSession $session, int $speed, float $accuracy)
    {
        $this->session = $session;
        $this->speed = $speed;
        $this->accuracy = $accuracy;
    }

    public function handle()
    {
        $typeSpeedResult = new TypeSpeedResult();
        $typeSpeedResult->sessionId = $this->session->id;
        $typeSpeedResult->speed = $this->speed;
        $typeSpeedResult->accuracy = $this->accuracy;
        $typeSpeedResult->save();
    }
}