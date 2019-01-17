<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
    
    /***************************************************************************/
    /**
     * Display the specified resource.
     *
     * @param  \App\EventVenue  $eventVenue
     * @return \Illuminate\Http\Response
     */
    public function show(){
        $sitemap = "aa";
        return view('sitemap.show',['sitemap' => $sitemap]);
    }
    
    
    
    
    
}
