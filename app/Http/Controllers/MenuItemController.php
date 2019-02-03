<?php

namespace App\Http\Controllers;

use App\MenuItem;
use App\Menu;

use Illuminate\Http\Request;
use Validator;

class MenuItemController extends Controller
{
    /***************************************************************************/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        
        $menuItems = MenuItem::latest()->paginate(20);
        //dump($menuItems);
        
        return view('menuItems.index',compact('menuItems'))
            ->with('i', (request()->input('page', 1) - 1) * 20);
        
    }
    
    /***************************************************************************/
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        
        $menu = Menu::orderBy('name')->pluck('name', 'id');
        $menuItems = MenuItem::orderBy('name')->pluck('name', 'id');
        //$menuItemsOrder = $this->getMenuItemsOrder();
        
        return view('menuItems.create')
            ->with('menuItems',$menuItems)
            ->with('menu',$menu);
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

        $menuItem = new MenuItem();
        $this->saveOnDb($request, $menuItem);
        
        return redirect()->route('menuItems.index')
                        ->with('success',__('messages.menu_added_successfully'));
        
    }

    /***************************************************************************/
    /**
     * Display the specified resource.
     *
     * @param  \App\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function show(MenuItem $menuItem){
        return view('menuItems.show',compact('menuItem'));
    }
    
    /***************************************************************************/
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuItem $menuItem){
        
        return view('menuItems.edit',compact('menuItem'));
    }

    /***************************************************************************/
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuItem $menuItem){

        request()->validate([
            'name' => 'required',
        ]);
        
        $this->saveOnDb($request, $menuItem);

        return redirect()->route('menuItems.index')
                        ->with('success',__('messages.menu_updated_successfully'));
    }
    
    /***************************************************************************/
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuItem $menuItem){
        $menuItem->delete();
        
        return redirect()->route('menuItems.index')
                        ->with('success',__('messages.menu_item_deleted_successfully'));
    }

    /***************************************************************************/
    /**
     * Save/Update the record on DB
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string $ret - the ordinal indicator (st, nd, rd, th)
     */

    function saveOnDb($request, $menuItem){
        $menuItem->name = $request->get('name');

        $menuItem->save();
    }

    /***************************************************************************/

    /*public function getMenuItemsOrder(){
        $ret = array();
        
        
        array_push($ret, "-");
        
        return $ret;
    }*/

}
