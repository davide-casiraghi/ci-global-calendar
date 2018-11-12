<?php

namespace App\Http\Controllers;

use App\Category;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;




class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->paginate(5);

        return view('categories.index',compact('categories'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        request()->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')
                        ->with('success','Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        request()->validate([
            'name' => 'required'
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')
                        ->with('success','Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category){
        $category->delete();
        return redirect()->route('categories.index')
                        ->with('success','Category deleted successfully');
    }

    // **********************************************************************

    /**
     * Return the single category datas by cat id
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
     public function categorydata($cat_id){
         $ret = DB::table('categories')->where('id', $cat_id)->first();
         //dump($ret);

         return $ret;
     }

}
