<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->numberBetween(1, 10),
        'name' => 'testName',
        'address' => 'testAddress',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ];
});
