<?php

namespace App\Features\Exam;

use App\Operations\Exam\Session\CheckExamForUserOperation;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class CheckExamForUserFeature extends Feature
{
    public function handle(Request $request)
    {
        $this->run(CheckExamForUserOperation::class, [
            'passed' => $request->passed,
            'sessionId' => $request->sessionId
        ]);
    }
}
