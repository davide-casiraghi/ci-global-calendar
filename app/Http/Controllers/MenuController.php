<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    /***************************************************************************/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        
        
        
    }
    
    /***************************************************************************/
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $categories = Category::pluck('name', 'id');
        //dump($categories);

        //return view('posts.create');
        return view('menus.create')->with('categories', $categories);
    }
    
    
    /***************************************************************************/
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
                'category_id' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
        
        $post = new Post();
        
        // Set the default language to edit the post for the admin to English (to avoid bug with null titles)
            App::setLocale('en');
            
        $this->saveOnDb($request, $post);    

        return redirect()->route('menus.index')
                        ->with('success',__('messages.article_added_successfully'));
    }

    /***************************************************************************/
    /**
     * Display the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country){
        return view('menus.show',compact('country'));
    }
    
    /***************************************************************************/
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country){
        $continents = Continent::pluck('name', 'id');

        return view('countries.edit',compact('country'))->with('continents',$continents);
    }

    /***************************************************************************/
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post){

        request()->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);
        
        
        // Set the default language to edit the post for the admin to English (to avoid bug with null titles)
            App::setLocale('en');
        
        $this->saveOnDb($request, $post);

        return redirect()->route('posts.index')
                        ->with('success',__('messages.article_updated_successfully'));
    }
    
    /***************************************************************************/
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country){
        $country->delete();
        return redirect()->route('countries.index')
                        ->with('success',__('messages.country_deleted_successfully'));
    }

    /***************************************************************************/


}
