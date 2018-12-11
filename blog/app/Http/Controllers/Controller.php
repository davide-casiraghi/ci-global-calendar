<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Get the current logged user id
     *
     * @param  none
     * @return boolean $ret - the current logged user id, if admin or super admin 0
     */
    function getLoggedAuthorId(){
        $user = Auth::user();
        
        if($user)
            $ret = $user;
            //$ret = (!$user->isSuperAdmin()&&!$user->isAdmin()) ? $user->id : 0;
        else
            $ret = null; 
            
        return $ret;
    }
}
