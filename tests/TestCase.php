<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    // Authenticate the user
        public function authenticate(){
            $user = factory(User::class)->make();
            $this->actingAs($user); 
        }
            
    // Authenticate the admin
        public function authenticateAsAdmin(){
            $user = factory(User::class)->make([
                'group' => 2,
            ]);
            
            $this->actingAs($user); 
        }
        
    // Authenticate the super admin
        public function authenticateAsSuperAdmin(){
            $user = factory(User::class)->make([
                'group' => 1,
            ]);
            
            $this->actingAs($user); 
        }
    
    
}
