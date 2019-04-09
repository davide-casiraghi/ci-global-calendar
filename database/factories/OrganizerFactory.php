<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Organizer::class, function (Faker $faker) {
    $organizer_name = $faker->name;
    $slug = Str::slug($organizer_name, '-').rand(10000, 100000);

    return [
        'name' => $organizer_name,
        'website' => $faker->url,
        'created_by' => '1',
        'slug' => $slug,
        'email' => $faker->unique()->safeEmail,
        'description' => $faker->paragraph,
        'phone' => $faker->e164PhoneNumber,
    ];
});
