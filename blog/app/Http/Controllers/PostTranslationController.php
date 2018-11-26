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
    public function create($postId, $languageCode)
    {

       return view('postTranslations.create')->with('postId',$postId)->with('languageCode',$languageCode);
    }

    // **********************************************************************

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PostTranslation  $postTranslation
     * @return \Illuminate\Http\Response
     */
    public function edit($postId, $languageCode){
        //dd($postId.$languageCode);
        return view('postTranslations.edit',compact('postTranslation'));
    }

    // **********************************************************************

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        dd($request);
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        /*Post::create($request->all());*/

        $postTranslation = new PostTranslation();
        $postTranslation->title = $request->get('title');
        $postTranslation->body = $request->get('body');

        $postTranslation->slug = $request->get('slug');
        if ($postTranslation->slug=== NULL) {
            $postTranslation->slug = str_slug($postTranslation->title, '-');
        }

        $postTranslation->before_content = $request->get('before_content');
        $postTranslation->after_content = $request->get('after_content');

        $postTranslation->save();

        return redirect()->route('posts.index')
                        ->with('success','Translation created successfully.');
    }

}
