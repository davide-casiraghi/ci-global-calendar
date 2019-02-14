<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryTranslation;

use Illuminate\Http\Request;

use Validator;

class CategoryTranslationController extends Controller
{
    /* Restrict the access to this resource just to logged in users */
    public function __construct(){
        $this->middleware('admin');
    }
    
    // **********************************************************************
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    // **********************************************************************
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($categoryId, $languageCode){
        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);
        
        return view('categoryTranslations.create')
                ->with('categoryId',$categoryId)
                ->with('languageCode',$languageCode)
                ->with('selectedLocaleName',$selectedLocaleName);
    }
    
    // **********************************************************************
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CategoryTranslation  $categoryTranslation
     * @return \Illuminate\Http\Response
     */
    public function edit($categoryId, $languageCode){
        $categoryTranslation = CategoryTranslation::where('category_id', $categoryId)
                        ->where('locale', $languageCode)
                        ->first();
                        
        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);
        
        return view('categoryTranslations.edit',compact('categoryTranslation'))
                    ->with('categoryId',$categoryId)
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
    public function store(Request $request)
    {
        //
    }

    // **********************************************************************
    /**
     * Display the specified resource.
     *
     * @param  \App\CategoryTranslation  $categoryTranslation
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryTranslation $categoryTranslation)
    {
        //
    }

    // **********************************************************************
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CategoryTranslation  $categoryTranslation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoryTranslation $categoryTranslation)
    {
        //
    }

    // **********************************************************************
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CategoryTranslation  $categoryTranslation
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryTranslation $categoryTranslation)
    {
        //
    }
}
