<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersExportController extends Controller
{
    /**
     * Display the export interface
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('usersExport.show');
    }
    
    // **********************************************************************

    /**
     * Export all the users in an excel that get downloaded
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        $users = User::select('id', 'name', 'email')
                        ->get();

        return redirect()->route('users-export-exported');
    }
    
    // **********************************************************************

    /**
     * Display the thank you view after the misuse report mail is sent (called by /misuse/thankyou route).
     *
     * @return \Illuminate\Http\Response
     */
    public function exported()
    {
        return view('usersExport.exported');
    }
}
