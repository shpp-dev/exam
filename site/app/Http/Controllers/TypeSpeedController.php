<?php


namespace App\Http\Controllers;

use App\Features\Exam\TypeSpeed\SaveTypeSpeedFeature;
use Lucid\Foundation\Http\Controller as Controller;


class TypeSpeedController extends Controller
{
    public function saveResult()
    {
        return $this->serve(SaveTypeSpeedFeature::class);
    }
}
