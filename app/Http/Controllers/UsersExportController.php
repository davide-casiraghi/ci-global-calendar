<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UsersExportController extends Controller
{
    /**
     * Display the export interface.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('usersExport.show');
    }

    // **********************************************************************

    /**
     * Export all the users in an excel that get downloaded.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
