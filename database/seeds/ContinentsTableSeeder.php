<?php

use Illuminate\Database\Seeder;

/*
|--------------------------------------------------------------------------
| Seeders
|--------------------------------------------------------------------------
|
| Seders are used to generate datas to populate the database of the test environment.
|
*/

class ContinentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $continents = [
            ['id' => '1', 'name' => 'Africa', 'code' => 'AF'],
            ['id' => '3', 'name' => 'North America', 'code' => 'NA'],
            ['id' => '4', 'name' => 'Oceania', 'code' => 'OC'],
            ['id' => '5', 'name' => 'Asia', 'code' => 'AS'],
            ['id' => '6', 'name' => 'Europe', 'code' => 'EU'],
            ['id' => '7', 'name' => 'South America', 'code' => 'SA'],
        ];

        foreach ($continents as $key => $continent) {
            DB::table('continents')->insert([
                'id' => $continent['id'],
                'name' => $continent['name'],
                'code' => $continent['code'],
            ]);
        }
    }
}
