<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ExamSession;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(ExamSession::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->numberBetween(1, 100),
        'started_at' => Carbon::now(),
        'finished_at' => Carbon::now(),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
