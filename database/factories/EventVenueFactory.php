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

$factory->define(App\EventVenue::class, function (Faker $faker) {
    $name = $faker->name;
    $slug = Str::slug($name, '-').rand(10000, 100000);

    return [
        'created_by' => 1,
        'name' => $name,
        'slug' => $slug,
        'description' => $faker->paragraph,
        'website' => $faker->url,
        'continent_id' => 2,
        'country_id' => 2,
        'city' => $faker->city,
        'address' => $faker->streetAddress,
        'zip_code' => $faker->postcode,
        'state_province' => $faker->state,
    ];
});
