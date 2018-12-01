<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'group', 'country_id', 'description', 'status','activation_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /*
        To recognize admin - https://laracasts.com/discuss/channels/laravel/user-admin-authentication
    */
    protected $casts = [
        'group' => 'int',
    ];

    public function isSuperAdmin()
    {
        if ($this->group == 1)
            return true;
        else
            return false;

    }

    public function isAdmin()
    {
        if ($this->group == 2)
            return true;
        else
            return false;
    }

}
