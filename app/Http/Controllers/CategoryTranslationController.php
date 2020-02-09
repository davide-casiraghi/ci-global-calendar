<?php

namespace App\Http\Controllers;

use App\CategoryTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class CategoryTranslationController extends Controller
{
    /***************************************************************************/
    /* Restrict the access to this resource just to logged in users */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /***************************************************************************/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function index()
    {
        //
    }*/

    /***************************************************************************/

    /**
     * Show the form for creating a new resource.
     * @param int $categoryId
     * @param string $languageCode
     * @return \Illuminate\View\View
     */
    public function create($categoryId, $languageCode)
    {
        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);

        return view('categoryTranslations.create')
                ->with('categoryId', $categoryId)
                ->with('languageCode', $languageCode)
                ->with('selectedLocaleName', $selectedLocaleName);
    }

    // **********************************************************************

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $categoryId
     * @param string $languageCode
     * @return \Illuminate\View\View
     */
    public function edit($categoryId, $languageCode)
    {
        $categoryTranslation = CategoryTranslation::where('category_id', $categoryId)
                        ->where('locale', $languageCode)
                        ->first();

        $selectedLocaleName = $this->getSelectedLocaleName($languageCode);

        return view('categoryTranslations.edit', compact('categoryTranslation'))
                    ->with('categoryId', $categoryId)
                    ->with('languageCode', $languageCode)
                    ->with('selectedLocaleName', $selectedLocaleName);
    }

    /***************************************************************************/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate form datas
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $categoryTranslation = new CategoryTranslation();
        $categoryTranslation->category_id = $request->get('category_id');
        $categoryTranslation->locale = $request->get('language_code');

        $categoryTranslation->name = $request->get('name');
        $categoryTranslation->description = $request->get('description');
        $categoryTranslation->slug = Str::slug($categoryTranslation->name, '-');

        $categoryTranslation->save();

        return redirect()->route('categories.index')
                        ->with('success', 'Translation created successfully.');
    }

    /***************************************************************************/

    /**
     * Display the specified resource.
     *
     * @param  \App\CategoryTranslation  $categoryTranslation
     * @return \Illuminate\Http\Response
     */
    /*public function show(CategoryTranslation $categoryTranslation)
    {
        //
    }*/

    /***************************************************************************/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        request()->validate([
            'name' => 'required',
        ]);

        $categoryTranslation = CategoryTranslation::where('id', $request->get('category_translation_id'));

        $category_t = [];
        $category_t['name'] = $request->get('name');
        $category_t['description'] = $request->get('description');
        $category_t['slug'] = Str::slug($request->get('name'), '-');

        $categoryTranslation->update($category_t);

        return redirect()->route('categories.index')
                        ->with('success', 'Translation updated successfully');
    }

    /***************************************************************************/

    /**
     * Remove the specified resource from storage.
     *
     * @param int $categoryTranslationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($categoryTranslationId)
    {
        $categoryTranslation = CategoryTranslation::find($categoryTranslationId);
        $categoryTranslation->delete();

        return redirect()->route('categories.index')
                        ->with('success', __('messages.category_translation_deleted_successfully'));
    }
}
