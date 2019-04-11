<?php

namespace App\Http\Controllers;

use App\Features\Admin\GetUsersListFeature;
use App\Features\Exam\CheckExamForUserFeature;
use App\Features\Exam\ListCheckedUsersFeature;
use App\Features\Exam\ListUncheckedUsersFeature;
use Lucid\Foundation\Http\Controller as Controller;

class AdminController extends Controller
{
    public function listUnchecked()
    {
        return $this->serve(GetUsersListFeature::class, ['passed' => null]);
    }

    public function listPassed()
    {
        return $this->serve(GetUsersListFeature::class, ['passed' => true]);
    }

    public function listFailed()
    {
        return $this->serve(GetUsersListFeature::class, ['passed' => false]);
    }

    public function check()
    {
        return $this->serve(CheckExamForUserFeature::class);
    }

}
