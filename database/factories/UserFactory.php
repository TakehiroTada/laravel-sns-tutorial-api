<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $lastName = $faker->lastKanaName;
    $firstName = $faker->firstKanaNameFemale;
    return [
        'account_id' => $faker->username,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'last_name' => $lastName,
        'first_name' => $firstName,
        'last_name_kana' => $lastName ,
        'first_name_kana' => $firstName,
        'remember_token' => Str::random(10),
    ];
});
