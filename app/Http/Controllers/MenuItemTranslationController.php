<?php

namespace App\Http\Controllers;

use App\Menu;
use App\MenuItem;
use App\MenuItemTranslation;

use Illuminate\Http\Request;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class MenuItemTranslationController extends Controller
{
    /* Restrict the access to this resource just to logged in users */
    public function __construct(){
        $this->middleware('admin');
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create($menuItemId, $languageCode){
        
        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);

        return view('menuItemTranslations.create')
                ->with('menuItemId',$menuItemId)
                ->with('languageCode',$languageCode)
                ->with('selectedLocaleName',$selectedLocaleName);
    }
    
    // **********************************************************************

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MenuItemTranslation  $menuItemTranslation
     * @return \Illuminate\Http\Response
     */
    public function edit($menuItemId, $languageCode){
        
        $menuItemTranslation = MenuItemTranslation::where('menu_item_id', $menuItemId)
                        ->where('locale', $languageCode)
                        ->first();
                        
        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);

        return view('menuItemTranslations.edit',compact('menuItemTranslation'))
                    ->with('menuItemId',$menuItemId)
                    ->with('languageCode',$languageCode)
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
                'name' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

        $menuItemTranslation = new MenuItemTranslation();

        $menuItemTranslation->menu_item_id = $request->get('menu_item_id');
        $menuItemTranslation->locale = $request->get('language_code');

        $menuItemTranslation->name = $request->get('title');
        $menuItemTranslation->compact_name = str_slug($menuItemTranslation->name, '-');

        $menuItemTranslation->save();

        return redirect()->route('menuItems.index')
                        ->with('success','Translation created successfully.');
    }
    
    
    
}
