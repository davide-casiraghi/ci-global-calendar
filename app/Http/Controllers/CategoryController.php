<?php

namespace App\Http\Controllers;

use App\Category;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    /* Restrict the access to this resource just to logged in users */
    public function __construct(){
        $this->middleware('admin');
    }
    
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
        
        // Validate form datas
            $validator = Validator::make($request->all(), [
                'name' => 'required'
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
        
        $category = new Category();

        //Category::create($request->all());
        $this->saveOnDb($request, $category);

        return redirect()->route('categories.index')
                        ->with('success',__('messages.category_added_successfully'));
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
    public function edit(Category $category){
        return view('categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category){
        request()->validate([
            'name' => 'required'
        ]);

        //$category->update($request->all());
        $this->saveOnDb($request, $category);

        return redirect()->route('categories.index')
                        ->with('success',__('messages.category_updated_successfully'));
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
                        ->with('success',__('messages.category_deleted_successfully'));
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

         return $ret;
     }

     // **********************************************************************

     /**
      * Save/Update the record on DB
      *
      * @param  \Illuminate\Http\Request  $request
      * @return string $ret - the ordinal indicator (st, nd, rd, th)
      */

     function saveOnDb($request, $category){
         $category->name = $request->get('name');
         $category->description = $request->get('description');
         $category->slug = str_slug($category->name, '-');

         $category->save();
     }

}
