<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Validator;

class CategoryController extends Controller
{
    /* Restrict the access to this resource just to logged in users */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::latest()->paginate(5);

        // Countries available for translations
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();

        return view('categories.index', compact('categories'))
            ->with('i', (request()->input('page', 1) - 1) * 5)
            ->with('countriesAvailableForTranslations', $countriesAvailableForTranslations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('categories.create');
    }

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

        $category = new Category();

        // Set the default language to edit the post for the admin to English (to avoid bug with null titles)
        App::setLocale('en');

        $this->saveOnDb($request, $category);

        return redirect()->route('categories.index')
                        ->with('success', __('messages.category_added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\View\View
     */
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\View\View
     */
    public function edit(Category $category)
    {

        // Set the default language to edit the post for the admin to English (to avoid bug with null titles)
        //App::setLocale('en');

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        request()->validate([
            'name' => 'required',
        ]);

        // Set the default language to edit the post for the admin to English (to avoid bug with null titles)
        App::setLocale('en');

        $this->saveOnDb($request, $category);

        return redirect()->route('categories.index')
                        ->with('success', __('messages.category_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
                        ->with('success', __('messages.category_deleted_successfully'));
    }

    /***************************************************************************/

    /**
     * Save/Update the record on DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return void.
     */
    public function saveOnDb($request, $category)
    {
        $category->name = $request->get('name');
        $category->description = $request->get('description');
        $category->slug = Str::slug($category->name, '-');

        $category->save();
    }
}
