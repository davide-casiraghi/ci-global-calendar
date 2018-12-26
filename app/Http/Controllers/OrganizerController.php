<?php

namespace App\Http\Controllers;

use App\Organizer;
use App\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Validator;

class OrganizerController extends Controller
{
    /* Restrict the access to this resource just to logged in users except show view */
    public function __construct(){
        $this->middleware('auth', ['except' => ['show']]);
    }
    
    /***************************************************************************/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        // Show just to the owner - Get created_by value if the user is not an admin or super admin
        $loggedUser = $this->getLoggedAuthorId();

        $searchKeywords = $request->input('keywords');

        if ($searchKeywords){
            $organizers = DB::table('organizers')
                ->when($loggedUser->id, function ($query, $loggedUserId) {
                    return $query->where('created_by', $loggedUserId);
                })
                ->when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('name', $searchKeywords)->orWhere('name', 'like', '%' . $searchKeywords . '%');
                })
                ->paginate(20);
        }
        else
            $organizers = DB::table('organizers')
            ->when($loggedUser->id, function ($query, $loggedUserId) {
                return $query->where('created_by', $loggedUserId);
            })
            ->paginate(20);

        return view('organizers.index',compact('organizers'))
            ->with('i', (request()->input('page', 1) - 1) * 20)
            ->with('searchKeywords',$searchKeywords);
    }
    
    /***************************************************************************/
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $users = User::pluck('name', 'id');
        $authorUserId = $this->getLoggedAuthorId();

        return view('organizers.create')
            ->with('users', $users)
            ->with('authorUserId',$authorUserId);
    }

    /***************************************************************************/
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        // Validate form datas
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required'
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
        
        $organizer = new Organizer();
        
        $this->saveOnDb($request, $organizer);

        return redirect()->route('organizers.index')
                        ->with('success',__('general.organizer').__('views.created_successfully'));
    }

    /***************************************************************************/
    /**
     * Display the specified resource.
     *
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function show(Organizer $organizer){
        return view('organizers.show',compact('organizer'));
    }

    /***************************************************************************/
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function edit(Organizer $organizer){
        $authorUserId = $this->getLoggedAuthorId();
        $users = User::pluck('name', 'id');

        return view('organizers.edit',compact('organizer'))
            ->with('users', $users)
            ->with('authorUserId',$authorUserId);
    }

    /***************************************************************************/
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organizer $organizer){
        request()->validate([
            'name' => 'required',
            'email' => 'required'
        ]);

        //$organizer->update($request->all());
        $this->saveOnDb($request, $organizer);

        return redirect()->route('organizers.index')
                        ->with('success','Organizer updated successfully');
    }

    /***************************************************************************/
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

    /***************************************************************************/
    /**
     * Save the record on DB
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
     public function saveOnDb($request, $organizer){
         
         $organizer->name = $request->get('name');
         //$organizer->description = $request->get('description');
         $organizer->description = clean($request->get('description'));
         $organizer->website = $request->get('website');
         $organizer->email = $request->get('email');
         $organizer->phone = $request->get('phone');

         $organizer->created_by = \Auth::user()->id;
         $organizer->slug = str_slug($organizer->name, '-').rand(10000, 100000);

         $organizer->save();
     }
     
    /***************************************************************************/
    /**
     * Open a modal in the event view when create organizer is clicked
     *
     * @return view
     */
    public function modal(){
        return view('organizers.modal');
    }

    /***************************************************************************/
    /**
     * Store a newly created organizer from the create event view modal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromModal(Request $request){
        $organizer = new Organizer();
        request()->validate([
            'name' => 'required'
        ]);

        $this->saveOnDb($request, $organizer);

        return redirect()->back()->with('message', 'Organizer created');
        //return redirect()->back()->with('message', __('auth.successfully_registered'));
        //return true;
    }

    // **********************************************************************




}
