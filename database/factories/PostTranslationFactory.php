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
    return [
        'post_id' => 3,
        'title' => $faker->name,
        'body' => $faker->text(1500),
        'slug' => str_slug($title, '-'),
        'locale' => str_random(10).".jpg",
    ];
});
