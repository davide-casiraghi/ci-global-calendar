<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            array(
                    'id' => '1',
                    'name' => 'Davide Casiraghi',
                    'email' => 'davide.casiraghi@gmail.com'
                    'password' => '$2y$10$PRsgbgfF0bV3FsFjbjOIDOW3JMSQYUYNsRhoEhVMPC6vc0yfoVsfm',
                    'group' => '1',
                    'country_id' => '1',
                    'status' => '1',
                ),
        );
        
        foreach($users as $key => $user) {
            DB::table('users')->insert([
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
                'group' => $user['group'],
                'country_id' => $user['country_id'],
                'status' => $user['status'],
            ]);
        }
    }
}
