<?php

namespace App\Http\Controllers;

use App\Features\Admin\DisableCheckingLocationFeature;
use App\Features\Admin\GetUsersExamsFeature;
use App\Features\Admin\EverCookieForClientFeature;
use App\Features\Exam\CheckExamForUserFeature;
use Lucid\Foundation\Http\Controller as Controller;

class AdminController extends Controller
{
    public function getUsersExams(string $status)
    {
        return $this->serve(GetUsersExamsFeature::class, ['status' => $status]);
    }

    public function checkExamForUser()
    {
        return $this->serve(CheckExamForUserFeature::class);
    }

    public function everCookieForClient($action)
    {
        return $this->serve(EverCookieForClientFeature::class, ['action' => $action]);
    }

    public function disableCheckingLocation()
    {
        return $this->serve(DisableCheckingLocationFeature::class);
    }
}
