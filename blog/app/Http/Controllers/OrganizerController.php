<?php

namespace App\Http\Controllers;

use App\Organizer;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        // Show just to the owner - Get created_by value if the user is not an admin or super admin
        $user = Auth::user();
        $createdBy = (!$user->isSuperAdmin()&&!$user->isAdmin()) ? $user->id : 0;

        $organizers = Organizer::latest()
            ->when($createdBy, function ($query, $createdBy) {
                return $query->where('created_by', $createdBy);
            })
            ->paginate(20);

        return view('organizers.index',compact('organizers'))
            ->with('i', (request()->input('page', 1) - 1) * 20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('organizers.create');
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

        $this->save($request);

        return redirect()->route('organizers.index')
                        ->with('success','Organizer created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function show(Organizer $organizer){
        return view('organizers.show',compact('organizer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function edit(Organizer $organizer){
        return view('organizers.edit',compact('organizer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organizer $organizer){
        request()->validate([
            'name' => 'required'
        ]);

        $organizer->update($request->all());

        return redirect()->route('organizers.index')
                        ->with('success','Organizer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organizer $organizer){
        $organizer->delete();
        return redirect()->route('organizers.index')
                        ->with('success','Organizer deleted successfully');
    }


    /**
     * Save the organier datas on DB
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
     public function save($request){
         $organizer = new Organizer();
         $organizer->name = $request->get('name');
         $organizer->image = $request->get('image');
         $organizer->website = $request->get('website');
         $organizer->facebook = $request->get('facebook');
         $organizer->email = $request->get('email');

         $organizer->created_by = \Auth::user()->id;
         $organizer->slug = str_slug($organizer->name, '-').rand(10000, 100000);

         $organizer->save();
     }
    /**
     * Open a modal in the event view when create organizer is clicked
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function modal(){
        return view('organizers.modal');
    }

    /**
     * Store a newly created organizer from the modal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromModal(Request $request){
        request()->validate([
            'name' => 'required'
        ]);

        $this->save($request);

        return redirect()->back()->with('message', 'Organizer created');
        //return redirect()->back()->with('message', __('auth.successfully_registered'));
        //return true;
    }

}
