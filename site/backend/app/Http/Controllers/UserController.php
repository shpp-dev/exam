<?php

namespace App\Http\Controllers;

use App\Features\Admin\GetExamDataForUsersFeature;
use App\Features\User\CreateUserFeature;
use App\Features\User\ExamRegistrationByCalendlyFeature;
use App\Features\User\GetExamStatusForUserFeature;
use Lucid\Foundation\Http\Controller as Controller;

class UserController extends Controller
{
    public function createUser()
    {
        return $this->serve(CreateUserFeature::class);
    }

    public function examStatusForUser()
    {
        return $this->serve(GetExamStatusForUserFeature::class);
    }

    public function examRegistrationByCalendly()
    {
        return $this->serve(ExamRegistrationByCalendlyFeature::class);
    }

    public function getExamDataForUsers()
    {
        return $this->serve(GetExamDataForUsersFeature::class);
    }
}
