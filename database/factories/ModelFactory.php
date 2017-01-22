<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Member::class, function (Faker\Generator $faker) {

    return [
        'key' => $faker->numberBetween(0,999999),
        'hash' => '$1$OSgsFlWE$79omYL8JCk0X0JLvREfjm1',
        'spokenName' => $faker->name,
        'ircName' => $faker->name,
        'addedBy' => $faker->numberBetween(0,999999),
        'dateCreated' => Carbon\Carbon::now()->timestamp,
        'lastLogin' => Carbon\Carbon::now()->timestamp,
        'isActive' => 1,
        'isAdmin' => 0,
    ];
});
