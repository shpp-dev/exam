<?php

namespace App\Http\Controllers;

use App\Features\Exam\CheckExamForUserFeature;
use App\Features\Exam\ListCheckedUsersFeature;
use App\Features\Exam\ListUncheckedUsersFeature;
use App\Features\User\CreateUserFeature;
use Lucid\Foundation\Http\Controller as Controller;

class UserController extends Controller
{
    public function createUser()
    {
        return $this->serve(CreateUserFeature::class);
    }
}
