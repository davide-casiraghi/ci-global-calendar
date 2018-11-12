<?php

namespace App\Http\Controllers;

use App\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $eventCategories = EventCategory::latest()->paginate(5);

        return view('eventCategories.index',compact('eventCategories'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
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
        request()->validate([
            'name' => 'required'
        ]);

        EventCategory::create($request->all());

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
    public function update(Request $request, EventCategory $eventCategory)
    {
        request()->validate([
            'name' => 'required'
        ]);

        $eventCategory->update($request->all());

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
}
