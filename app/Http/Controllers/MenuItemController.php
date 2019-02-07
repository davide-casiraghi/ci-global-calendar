<?php

namespace App\Http\Controllers;

use App\MenuItem;
use App\Menu;

use Illuminate\Http\Request;
use Validator;

class MenuItemController extends Controller
{
    
    /* Restrict the access to this resource just to logged in users, except some */
    public function __construct(){
        $this->middleware('admin', ['except' => ['updateOrder']]);
    }
    
    /***************************************************************************/
    /**
     * Display a listing of the resource.
     * @param  $id - the menu id
     * @return \Illuminate\Http\Response
     */
    public function index($id){
        
        $selectedMenuName = Menu::find($id)->name;
        $menuItems = MenuItem::where('menu_id','=',$id)
                                ->oldest()->get();
        
        // Create menu items tree                        
            $new = array();
            foreach ($menuItems as $menuItem){
                $new[$menuItem['parent_item_id']][] = $menuItem;
            }
            $menuItemsTree = $this->createTree($new, $new[0]); 
            dump($menuItemsTree);
            
        return view('menuItems.index',compact('menuItemsTree'))
                    ->with('selectedMenuName', $selectedMenuName);
        
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
        //dd($request->menu_id);
        
        return redirect()->route('menuItemsIndex', ['id' => $request->menu_id] )
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
        
        $menu = Menu::orderBy('name')->pluck('name', 'id');
        $menuItems = MenuItem::orderBy('name')->pluck('name', 'id');
        $menuItemsSameMenuAndLevel = $this->getItemsSameMenuAndLevel($menuItem->menu_id, $menuItem->parent_item_id);                         
        
        return view('menuItems.edit',compact('menuItem'))
                    ->with('menuItems',$menuItems)
                    ->with('menuItemsSameMenuAndLevel',$menuItemsSameMenuAndLevel)
                    ->with('menu',$menu);
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

        return redirect()->route('menuItemsIndex', ['id' => $request->menu_id] )
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
        $menuItem->compact_name = str_slug($request->get('name'), '-');  
        if (!$request->get('parent_item_id')){
            $menuItem->parent_item_id = 0;
        }
        else{
            $menuItem->parent_item_id = $request->get('parent_item_id');
        }
        
        $menuItem->url = $request->get('url');
        $menuItem->font_awesome_class = $request->get('font_awesome_class');
        $menuItem->lang_string = $request->get('lang_string');
        $menuItem->route = $request->get('route');
        $menuItem->type = $request->get('type');
        $menuItem->menu_id = $request->get('menu_id');
        $menuItem->access = $request->get('access');
        
        //dd($request->get('order'));
        if ($request->get('order')){
            switch ($request->get('order')) {
                case 'first':
                    // code...
                    break;
                
                case 'last':
                    // code...
                    break;
                
                case $menuItem->order:
                    // do nothing if it's the same
                    break;
                default:
                    //$menuItem->order = $request->get('order');
                    break;
            }
        }
        

        $menuItem->save();
    }

    /***************************************************************************/
    /**
     * Update the menu items order on DB (called by /resources/js/components/UlListDraggable.vue)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string $ret - the ordinal indicator (st, nd, rd, th)
     */

    function updateOrder(Request $request){
        
        foreach ($request->items as $key => $item) {
            $item['order'] = $key+1;
            $menuItem = MenuItem::find($item['id']);
            
            $menuItem->update($item);   
        }
    }

    /***************************************************************************/
    /**
     * Create array tree from array list - it support more than 1 parentid[0] element
     * https://stackoverflow.com/questions/4196157/create-array-tree-from-array-list
     *
     * @param  $list
     * @param  $parent
     * @return string $key - the index of the parent item
     */

    function createTree(&$list, $parent){
        $tree = array();
        foreach ($parent as $k=>$l){
            if(isset($list[$l['id']])){
                $l['children'] = $this->createTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        } 
        return $tree;
    }
    
    /***************************************************************************/
    /**
     * Get the items of the same menu and level
     *
     * @param int $menuId - the menu id
     * @param  int $parentItemId - the parent menu item id
     * @return array $ret;
     */

    function getItemsSameMenuAndLevel($menuId, $parentItemId){
        $ret = MenuItem::where('parent_item_id','=',$parentItemId)
                                        ->where('menu_id','=',$menuId)
                                        ->orderBy('order')
                                        ->pluck('name', 'id');             
        return $ret;
    }
    

}
