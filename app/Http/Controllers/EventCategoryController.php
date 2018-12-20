<?php

namespace App\Http\Controllers;

use App\EventCategory;
use Illuminate\Http\Request;
use Validator;

class EventCategoryController extends Controller
{
    /* Restrict the access to this resource just to logged in users except show view */
    public function __construct(){
        $this->middleware('auth', ['except' => ['show']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $eventCategories = EventCategory::latest()->paginate(20);

        return view('eventCategories.index',compact('eventCategories'))
            ->with('i', (request()->input('page', 1) - 1) * 20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('eventCategories.create');
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
        
        $eventCategory = new EventCategory();

        $this->saveOnDb($request, $eventCategory);

        return redirect()->route('eventCategories.index')
                        ->with('success','Event category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EventCategory  $eventCategory
     * @return \Illuminate\Http\Response
     */
    public function show(EventCategory $eventCategory){
        return view('eventCategories.show',compact('eventCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EventCategory  $eventCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(EventCategory $eventCategory){

        return view('eventCategories.edit',compact('eventCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EventCategory  $eventCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventCategory $eventCategory){
        request()->validate([
            'name' => 'required'
        ]);

        $this->saveOnDb($request, $eventCategory);

        return redirect()->route('eventCategories.index')
                        ->with('success','Event category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EventCategory  $eventCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventCategory $eventCategory)
    {
        $eventCategory->delete();

        return redirect()->route('eventCategories.index')
                        ->with('success','Event category deleted successfully');
    }

    // **********************************************************************

    /**
     * Return the single event category datas by cat id
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
     public function eventcategorydata($cat_id){
         $ret = DB::table('event_categories')->where('id', $cat_id)->first();
         //dump($ret);

         return $ret;
     }

     // **********************************************************************

     /**
      * Save/Update the record on DB
      *
      * @param  \Illuminate\Http\Request  $request
      * @return string $ret - the ordinal indicator (st, nd, rd, th)
      */

     function saveOnDb($request, $eventCategory){
         $eventCategory->name = $request->get('name');
         $eventCategory->slug = str_slug($eventCategory->name, '-');

         $eventCategory->save();
     }
}
