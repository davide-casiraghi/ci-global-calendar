<?php

namespace App\Http\Controllers;

use App\Menu;

use Illuminate\Http\Request;
use Validator;

class MenuController extends Controller
{
    /* Restrict the access to this resource just to logged in users, except some */
    public function __construct(){
        $this->middleware('admin');
    }
    
    /***************************************************************************/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        
        $menus = Menu::orderBy('name')->get();
        
        return view('menus.index',compact('menus'));
        
    }
    
    /***************************************************************************/
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('menus.create');
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
                'name' => 'required'
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

        $menu = new Menu();
        $this->saveOnDb($request, $menu);
        
        return redirect()->route('menus.index')
                        ->with('success',__('messages.menu_added_successfully'));
        
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
        
        return view('menus.edit',compact('menu'));
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
            'name' => 'required',
        ]);
        
        $this->saveOnDb($request, $menu);

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
    /**
     * Save/Update the record on DB
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string $ret - the ordinal indicator (st, nd, rd, th)
     */

    function saveOnDb($request, $menu){
        $menu->name = $request->get('name');

        $menu->save();
    }

    /***************************************************************************/

}
