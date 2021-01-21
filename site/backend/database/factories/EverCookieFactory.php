<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EverCookie;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(EverCookie::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->numberBetween(1, 10),
        'location' => 'testLocation',
        'client' => $faker->unique()->numberBetween(1, 10),
        'token' => 'testToken',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
