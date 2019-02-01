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

        
    }
    
    
    /***************************************************************************/
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        
        
    }

    /***************************************************************************/
    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu){
        return view('menus.show',compact('menu'));
    }
    
    /***************************************************************************/
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu){
        

        return view('menus.edit',compact('country'))->with('continents',$continents);
    }

    /***************************************************************************/
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu){

        request()->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);
        
        $this->saveOnDb($request, $post);

        return redirect()->route('menus.index')
                        ->with('success',__('messages.menu_updated_successfully'));
    }
    
    /***************************************************************************/
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu){
        $menu->delete();
        return redirect()->route('menus.index')
                        ->with('success',__('messages.menu_deleted_successfully'));
    }

    /***************************************************************************/


}
