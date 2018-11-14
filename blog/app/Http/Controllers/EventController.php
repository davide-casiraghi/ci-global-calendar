<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventCategory;
use App\Teacher;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $searchKeywords = $request->input('keywords');
        $searchCategory = $request->input('category_id');

        if ($searchKeywords||$searchCategory){
            $events = DB::table('events')
                ->when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('title', $searchKeywords)->orWhere('title', 'like', '%' . $searchKeywords . '%');
                })
                ->when($searchCategory, function ($query, $searchCategory) {
                    return $query->where('category_id', '=', $searchCategory);
                })
                ->paginate(20);
        }
        else
            $events = Event::latest()->paginate(20);


        $eventCategories = EventCategory::pluck('name', 'id');

        return view('events.index',compact('events'))
            ->with('i', (request()->input('page', 1) - 1) * 20)->with('eventCategories',$eventCategories)->with('searchKeywords',$searchKeywords)->with('searchCategory',$searchCategory);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $eventCategories = EventCategory::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');

        //return view('events.create');
        return view('events.create')->with('eventCategories', $eventCategories)->with('teachers', $teachers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $event = new Event();
        $event->title = $request->get('title');
        $event->description = $request->get('description');
        //$event->created_by = $request->get('created_by');
        $event->created_by = \Auth::user()->id;
        $event->organized_by = $request->get('organized_by');
        //$event->slug = $request->get('slug');
        $event->slug = str_slug($event->title, '-').rand(100000, 1000000);

        $event->category_id = $request->get('category_id');
        $event->image = $request->get('image');
        $event->facebook_link = $request->get('facebook_link');
        $event->status = $request->get('status');

        dd($request->replace($request->all()));

        $event->save();


        //$event->teachers()->sync($request->get('teachers'));
        //$event->teachers()->sync([1, 2]);

        $teachers = implode(', ', $request->get('tea'));
        $event->teachers()->sync($teachers);


        return redirect()->route('events.index')
                        ->with('success','Event created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('events.show',compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $eventCategories = EventCategory::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');

        return view('events.edit',compact('event'))->with('eventCategories', $eventCategories)->with('teachers', $teachers);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event){
        request()->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $event->update($request->all());

        return redirect()->route('events.index')
                        ->with('success','Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event){
        $event->delete();
        return redirect()->route('events.index')
                        ->with('success','Event deleted successfully');
    }
}
