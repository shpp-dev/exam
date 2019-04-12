<?php

namespace App\Http\Controllers;

use App\Features\Admin\GetUsersListFeature;
use App\Features\Exam\CheckExamForUserFeature;
use Lucid\Foundation\Http\Controller as Controller;

class AdminController extends Controller
{
    public function list(string $status)
    {
        return $this->serve(GetUsersListFeature::class, ['status' => $status]);
    }

    public function check()
    {
        return $this->serve(CheckExamForUserFeature::class);
    }
}
