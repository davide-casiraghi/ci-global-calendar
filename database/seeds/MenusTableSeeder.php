<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            ['id' => '1', 'name' => 'Main menu - Left', 'position' => '1'],
            ['id' => '4', 'name' => 'Main menu - Right', 'position' => '2'],
            ['id' => '3', 'name' => 'Footer menu', 'position' => '3'],
        ];

        foreach ($menus as $key => $menu) {
            DB::table('menus')->insert([
                'id' => $menu['id'],
                'name' => $menu['name'],
                'position' => $menu['position'],
            ]);
        }
    }
}
