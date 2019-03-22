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

$factory->define(App\PostTranslation::class, function (Faker $faker) {
    $title = $faker->name;

    return [
        'title' => $title,
        'body' => $faker->text(1500),
        'slug' => Str::slug($title, '-'),
        /*'locale' => 'it',*/
    ];
});
