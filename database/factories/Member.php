<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\User;
use Faker\Generator as Faker;

$factory->define(\App\Member::class, function (Faker $faker) {
    $users = User::all();

    return [
        'key' => $faker->numberBetween(0,999999),
        'hash' => sha1('1111'),
        'spoken_name' => $faker->name,
        'irc_name' => $faker->name,
        'added_by' => $users->random()->id,
        'date_created' => Carbon\Carbon::now(),
        'last_login' => Carbon\Carbon::now(),
        'active' => 1,
        'admin' => 0,
    ];
});
