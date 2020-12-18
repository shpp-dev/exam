<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Lucid\Foundation\Http\Controller as Controller;

class ConfigController extends Controller
{
    public function update()
    {
        Artisan::call('ptp:config-update');
    }
}
