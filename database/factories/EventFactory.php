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

$factory->define(App\Event::class, function (Faker $faker) {
    $venue = factory(\App\EventVenue::class)->create();
    $user = factory(\App\User::class)->create();

    // Generate two teachers and get the IDs eg (3, 4, 5)
    $teachers = factory(App\Teacher::class, 2)->create();
    $teachers_id = '';
    $i = 0;
    $len = count($teachers);
    foreach ($teachers as $key => $teacher) {
        $teachers_id .= $teacher->id;
        if ($i != $len - 1) {  // not last
            $teachers_id .= ', ';
        }
        $i++;
    }

    // Generate two organizers and get the IDs eg (3, 4, 5)
    $organizers = factory(App\Organizer::class, 2)->create();
    $organizers_id = '';
    $i = 0;
    $len = count($organizers);
    foreach ($organizers as $key => $organizer) {
        $organizers_id .= $organizer->id;
        if ($i != $len - 1) {  // not last
            $organizers_id .= ', ';
        }
        $i++;
    }

    $title = $this->faker->sentence($nbWords = 3);

    return [
            'title' => $title,
            'category_id' => '3',
            'description' => $this->faker->paragraph,
            'created_by' => $user->id,
            'slug' => Str::slug($title, '-').rand(100000, 1000000),
            //'multiple_teachers' => $teachers_id,
            //'multiple_organizers' => $organizers_id,
            'venue_id' => $venue->id,
            //'startDate' => '10/01/2022',
            //'endDate' => '12/01/2022',
            //'time_start' => '6:00 PM',
            //'time_end' => '8:00 PM',
            'repeat_type' => '1',
            'facebook_event_link' => 'https://www.facebook.com/'.$this->faker->word,
            'website_event_link' => $this->faker->url,
    ];
});
