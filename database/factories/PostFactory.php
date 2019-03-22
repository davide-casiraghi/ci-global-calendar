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
        'title' => $title,
        'created_by' => 1,
        'body' => $faker->text(1500),
        'category_id' => 2,
        'introimage' => Str::random(10).'.jpg',
        'slug' => Str::slug($title, '-'),
        'status' => 2, // 2 enabled, 1 disabled
    ];
});
