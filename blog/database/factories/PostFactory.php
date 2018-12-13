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

$factory->define(App\Post::class, function (Faker $faker) {
        $title = $faker->name;
    return [
        'title' => $faker->name,
        'body' => $faker->text(1500),
        'author_id' => 2,
        'category_id' => 2,
        'image' => str_random(10).".jpg",
        'slug' => str_slug($title, '-'),
        'status' => $faker->randomElement($array = array (2,2,2,2,2,2,2,1)), // 2 enabled, 1 disabled
    ];
});
