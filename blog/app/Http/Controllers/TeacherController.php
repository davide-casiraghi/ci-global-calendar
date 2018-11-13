<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $teachers = Teacher::latest()->paginate(5);

        return view('teachers.index',compact('teachers'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        /*request()->validate([
            'name' => 'required',
            'slug' => 'required',
        ]);

        Teacher::create($request->all());*/

        request()->validate([
            'name' => 'required'
        ]);

        $teacher = new Teacher();
        $teacher->name = $request->get('name');
        $teacher->bio = $request->get('bio');
        $teacher->created_by = \Auth::user()->id;
        $teacher->country = $request->get('country');
        $teacher->year_starting_practice = $request->get('year_starting_practice');
        $teacher->year_starting_teach = $request->get('year_starting_teach');
        $teacher->significant_teachers = $request->get('significant_teachers');
        $teacher->image = $request->get('image');
        $teacher->website = $request->get('website');
        $teacher->facebook = $request->get('facebook');
        $teacher->slug = str_slug($teacher->name, '-').rand(10000, 100000);

        $teacher->save();

        return redirect()->route('teachers.index')
                        ->with('success','Teacher created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher){
        return view('teachers.show',compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher){
        return view('teachers.edit',compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher){
        request()->validate([
            'name' => 'required'
        ]);

        $teacher->update($request->all());

        return redirect()->route('teachers.index')
                        ->with('success','Teacher updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher){
        $teacher->delete();
        return redirect()->route('teachers.index')
                        ->with('success','Teacher deleted successfully');
    }
}
