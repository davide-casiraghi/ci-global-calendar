<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use App\Organizer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller
{
    /* Restrict the access to this resource just to logged in users except show view */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'organizerBySlug']]);
    }

    /***************************************************************************/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // To show just the organizers created by the the user - If admin or super admin is set to null show all the organizers
        $authorUserId = ($this->getLoggedAuthorId()) ? $this->getLoggedAuthorId() : null; // if is 0 (super admin or admin) it's setted to null to avoid include it in the query

        $searchKeywords = $request->input('keywords');

        if ($searchKeywords) {
            $organizers = DB::table('organizers')
                ->when($authorUserId, function ($query, $authorUserId) {
                    return $query->where('created_by', $authorUserId);
                })
                ->when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('name', $searchKeywords)->orWhere('name', 'like', '%'.$searchKeywords.'%');
                })
                ->paginate(20);
        } else {
            $organizers = DB::table('organizers')
            ->when($authorUserId, function ($query, $authorUserId) {
                return $query->where('created_by', $authorUserId);
            })
            ->paginate(20);
        }

        return view('organizers.index', compact('organizers'))
            ->with('i', (request()->input('page', 1) - 1) * 20)
            ->with('searchKeywords', $searchKeywords);
    }

    /***************************************************************************/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::pluck('name', 'id');
        $authorUserId = $this->getLoggedUser();

        return view('organizers.create')
            ->with('users', $users)
            ->with('authorUserId', $authorUserId);
    }

    /***************************************************************************/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate form datas
        $validator = $this->organizersValidator($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $organizer = new Organizer();
        $this->saveOnDb($request, $organizer);

        return redirect()->route('organizers.index')
                        ->with('success', __('messages.organizer_added_successfully'));
    }

    /***************************************************************************/

    /**
     * Display the specified resource.
     *
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function show(Organizer $organizer)
    {
        return view('organizers.show', compact('organizer'));
    }

    /***************************************************************************/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function edit(Organizer $organizer)
    {
        if (Auth::user()->id == $organizer->created_by || Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()) {
            $authorUserId = $this->getLoggedAuthorId();
            $users = User::pluck('name', 'id');

            return view('organizers.edit', compact('organizer'))
                ->with('users', $users)
                ->with('authorUserId', $authorUserId);
        } else {
            return redirect()->route('home')->with('message', __('auth.not_allowed_to_access'));
        }
    }

    /***************************************************************************/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organizer $organizer)
    {
        // Validate form datas
        $validator = $this->organizersValidator($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $this->saveOnDb($request, $organizer);

        return redirect()->route('organizers.index')
                        ->with('success', __('messages.organizer_updated_successfully'));
    }

    /***************************************************************************/

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organizer $organizer)
    {
        $organizer->delete();

        return redirect()->route('organizers.index')
                        ->with('success', __('messages.organizer_deleted_successfully'));
    }

    /***************************************************************************/

    /**
     * Save the record on DB.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organizer  $organizer
     * @return void
     */
    public function saveOnDb($request, $organizer)
    {
        $organizer->name = $request->get('name');
        $organizer->description = clean($request->get('description'));
        $organizer->website = $request->get('website');
        $organizer->email = $request->get('email');
        $organizer->phone = $request->get('phone');

        $organizer->created_by = \Auth::user()->id;
        if (! $organizer->slug) {
            $organizer->slug = Str::slug($organizer->name, '-').'-'.rand(10000, 100000);
        }

        $organizer->save();
    }

    /***************************************************************************/

    /**
     * Open a modal in the event view when create organizer is clicked.
     *
     * @return view
     */
    public function modal()
    {
        return view('organizers.modal');
    }

    /***************************************************************************/

    /**
     * Store a newly created organizer from the create event view modal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromModal(Request $request)
    {
        $organizer = new Organizer();
        request()->validate([
            'name' => 'required',
        ]);

        $this->saveOnDb($request, $organizer);

        return redirect()->back()->with('message', 'Organizer created');
        //return redirect()->back()->with('message', __('auth.successfully_registered'));
        //return true;
    }

    /***************************************************************************/

    /**
     * Return the organizer by SLUG. (eg. http://websitename.com/organizer/xxxxx).
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function organizerBySlug($slug)
    {
        $organizer = Organizer::
                where('slug', $slug)
                ->first();

        return $this->show($organizer);
    }

    /***************************************************************************/

    /**
     * Return the validator with all the defined constraint.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Validation\Validator
     */
    public function organizersValidator($request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'website' => 'nullable|url',
        ];
        $messages = [
            'website.url' => 'The website link is invalid. It should start with https://',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        return $validator;
    }
}
