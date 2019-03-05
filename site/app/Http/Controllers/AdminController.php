<?php

namespace App\Http\Controllers;

use App\Features\Exam\CheckExamForUserFeature;
use App\Features\Exam\ListCheckedUsersFeature;
use App\Features\Exam\ListUncheckedUsersFeature;
use Lucid\Foundation\Http\Controller as Controller;

class AdminController extends Controller
{
    public function listUnchecked()
    {
        return $this->serve(ListUncheckedUsersFeature::class);
    }

    public function listChecked()
    {
        return $this->serve(ListCheckedUsersFeature::class);
    }

    public function check()
    {
        return $this->serve(CheckExamForUserFeature::class);
    }

}
