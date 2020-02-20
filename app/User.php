<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /***************************************************************************/

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'group', 'country_id', 'description', 'status', 'activation_code', 'accept_terms',
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

    /***************************************************************************/

    /**
     * Return true if the user is a super admin.
     *
     * @return bool $ret
     */
    public function isSuperAdmin()
    {
        if ($this->group == 1) {
            return true;
        } else {
            return false;
        }
    }

    /***************************************************************************/

    /**
     * Return true if the user is an admin.
     *
     * @return bool $ret
     */
    public function isAdmin()
    {
        if ($this->group == 2) {
            return true;
        } else {
            return false;
        }
    }

    /***************************************************************************/

    /**
     * Return the user group description string.
     *
     * @param  int|null  $group_id
     * @return string $ret
     */
    public static function getUserGroupString($group_id)
    {
        $ret = '';
        switch ($group_id) {
             case null:
                 $ret = 'Manager';
                 break;

             case 2:
                 $ret = 'Administrator';
                 break;

             case 1:
                 $ret = 'Super Administrator';
                 break;
         }

        return $ret;
    }

    /***************************************************************************/

    /**
     * Return true if the user is logged as super admin.
     *
     * @return bool $ret
     */
    public static function loggedAsSuperAdmin()
    {
        $user = Auth::user();
        if (! $user) {
            return false;
        } elseif ($user->group == 1) {
            return true;
        } else {
            return false;
        }
    }

    /***************************************************************************/

    /**
     * Return true if the user is logged as admin.
     *
     * @return bool $ret
     */
    public static function loggedAsAdmin()
    {
        $user = Auth::user();
        if (! $user) {
            return false;
        } elseif ($user->group == 2) {
            return true;
        } else {
            return false;
        }
    }
}
