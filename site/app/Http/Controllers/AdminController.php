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
        $this->serve(ListUncheckedUsersFeature::class);
    }

    public function listChecked()
    {
        $this->serve(ListCheckedUsersFeature::class);
    }

    public function check()
    {
        $this->serve(CheckExamForUserFeature::class);
    }

}
