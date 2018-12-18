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

$factory->define(App\Teacher::class, function (Faker $faker) {
    
    $teacher_name = $faker->name;
    $slug = str_slug($teacher_name, '-').rand(10000, 100000);
    $year_starting_practice = $faker->numberBetween($min = 1972, $max = 2018);
    $year_starting_teach = $faker->numberBetween($min = $year_starting_practice, $max = 2018);
    
    return [
        'name' => $teacher_name,
        'bio' => $faker->paragraph,
        'year_starting_practice' => $year_starting_practice,
        'year_starting_teach' => $year_starting_teach,
        'significant_teachers' => $faker->paragraph,
        'profile_picture' => str_random(10).".jpg",
        'website' => $faker->url,
        'facebook' => "https://www.facebook.com/".$faker->word,
        'created_by' => '1',
        'slug' => $slug,
        'country_id' => $faker->numberBetween($min = 1, $max = 253),
    ];
});
