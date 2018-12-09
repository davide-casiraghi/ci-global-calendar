<?php

use Faker\Generator as Faker;

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'group' => $faker->randomElement($array = array (2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)), // 1 super admin, 2 admin
        'country_id' => $faker->numberBetween($min = 1, $max = 253),
        'description' => $faker->paragraph,
        'accept_terms' => 1,
        'activation_code' => str_random(10),
        'status' => $faker->randomElement($array = array (1,1,1,1,1,1,1,0)), // 1 enabled, 0 disabled
    ];
});
