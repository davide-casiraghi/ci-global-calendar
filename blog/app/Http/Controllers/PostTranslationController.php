<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostTranslation;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PostTranslationController extends Controller
{

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
            dd($post);
       return view('postTranslations.create');
    }

    // **********************************************************************

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PostTranslation  $postTranslation
     * @return \Illuminate\Http\Response
     */
    public function edit($postId, $languageCode){
        dd($postId.$languageCode);
        return view('postTranslations.edit',compact('postTranslation'));
    }


}
