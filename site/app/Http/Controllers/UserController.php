<?php

namespace App\Http\Controllers;

use App\Features\User\CreateUserFeature;
use App\Features\User\ExamRegistrationByCalendlyFeature;
use Lucid\Foundation\Http\Controller as Controller;

class UserController extends Controller
{
    public function createUser()
    {
        return $this->serve(CreateUserFeature::class);
    }

    public function examRegistrationByCalendly()
    {
        return $this->serve(ExamRegistrationByCalendlyFeature::class);
    }
}
