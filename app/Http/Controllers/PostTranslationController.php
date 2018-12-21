<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostTranslation;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Validator;

class PostTranslationController extends Controller
{

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create($postId, $languageCode){
        
        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);

        return view('postTranslations.create')
                ->with('postId',$postId)
                ->with('languageCode',$languageCode)
                ->with('selectedLocaleName',$selectedLocaleName);
    }

    // **********************************************************************

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PostTranslation  $postTranslation
     * @return \Illuminate\Http\Response
     */
    public function edit($postId, $languageCode){
        
        $postTranslation = PostTranslation::where('post_id', $postId)
                        ->where('locale', $languageCode)
                        ->first();
                        
        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);

        return view('postTranslations.edit',compact('postTranslation'))
                    ->with('postId',$postId)->with('languageCode',$languageCode)
                    ->with('selectedLocaleName',$selectedLocaleName);
    }

    // **********************************************************************

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        
        // Validate form datas
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'body' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

        $postTranslation = new PostTranslation();

        $postTranslation->post_id = $request->get('post_id');
        $postTranslation->locale = $request->get('language_code');

        $postTranslation->title = $request->get('title');
        $postTranslation->body = $request->get('body');
        $postTranslation->slug = str_slug($postTranslation->title, '-');

        $postTranslation->before_content = $request->get('before_content');
        $postTranslation->after_content = $request->get('after_content');
        
        $postTranslation->save();

        return redirect()->route('posts.index')
                        ->with('success','Translation created successfully.');
    }

    // **********************************************************************

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PostTranslation  $postTranslation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        request()->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $postTranslation = PostTranslation::where ('id', $request->get('post_translation_id'));

        $pt['title'] = $request->get('title');
        $pt['body'] = $request->get('body');
        $pt['slug'] = str_slug($request->get('title'), '-');

        $pt['before_content'] = $request->get('before_content');
        $pt['after_content'] = $request->get('after_content');

        $postTranslation->update($pt);

        return redirect()->route('posts.index')
                        ->with('success','Post updated successfully');
    }
    
    // **********************************************************************
   /**
    * Get the language name from language code
    *
    * @param  $postTranslation string - the country code
    * @return string the country name
    */    
   public function getSelectedLocaleName($languageCode){
       
       $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();
       $ret = $countriesAvailableForTranslations[$languageCode]['name'];
       
       return $ret;
   }

}
