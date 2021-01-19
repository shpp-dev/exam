<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->numberBetween(1, 10),
        'account_id' => $faker->unique()->numberBetween(1, 10),
        'email' => $faker->unique()->safeEmail,
        'exam_datetime' => null,
        'exam_location' => null,
        'check_location' => true,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ];
});
