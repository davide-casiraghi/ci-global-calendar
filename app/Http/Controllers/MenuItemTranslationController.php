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
    
    
    
}
