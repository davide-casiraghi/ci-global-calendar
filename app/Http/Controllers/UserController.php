<?php

namespace App\Http\Controllers;

use App\User;
use App\Country;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    /* Restrict the access to this resource just to logged in users */
    public function __construct(User $user){
        $this->middleware('admin', ['except' => ['edit']]);
        
        
        //$user = $this->auth->user()  // null
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countries = Country::orderBy('countries.name')->pluck('name', 'id');

        $searchKeywords = $request->input('keywords');
        $searchCountry = $request->input('country_id');

       if ($searchKeywords||$searchCountry){
           $users = DB::table('users')
               ->when($searchKeywords, function ($query, $searchKeywords) {
                   return $query->where('name', $searchKeywords)->orWhere('name', 'like', '%' . $searchKeywords . '%');
               })
               ->when($searchCountry, function ($query, $searchCountry) {
                   return $query->where('country_id', '=', $searchCountry);
               })
               ->paginate(20);
       }
       else
           $users = User::latest()->paginate(20);

       return view('users.index',compact('users'))
           ->with('i', (request()->input('page', 1) - 1) * 20)->with('countries', $countries)->with('searchKeywords',$searchKeywords)->with('searchCountry',$searchCountry);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::pluck('name', 'id');

        return view('users.create')->with('countries', $countries);
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
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

        $user = new User();
        
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));

        $user->group = $request->get('group');
        $user->status = $request->get('status');
        $user->country_id = $request->get('country_id');
        //$user->description = $request->get('description');
        $user->description = clean($request->get('description'));

        $user->save();

        return redirect()->route('users.index')
                        ->with('success',__('messages.user_added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $countries = Country::pluck('name', 'id');
        $role = User::getUserGroupString($user->group);
        
        return view('users.show',compact('user'))
                    ->with('countries', $countries)
                    ->with('role', $role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user){
        
        if (Auth::user()->id == $user->id || Auth::user()->isSuperAdmin()|| Auth::user()->isAdmin()){  // Just Admins and the owner are allowed to edit the user profile
            
            $countries = Country::pluck('name', 'id');

            // We check the user group to hide the group selection dropdown when the user is a guest
                $logged_user = Auth::user();
                $logged_user_group = ($logged_user) ? $logged_user->group : null;

            return view('users.edit',compact('user'))
                    ->with('countries', $countries)
                    ->with('logged_user_group', $logged_user_group);
    	}
    	else{
    		return redirect()->route('home')->with('message', __('auth.not_allowed_to_access'));
    	}        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255'
        ]);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        if ($request->get('password'))
            $user->password = Hash::make($request->get('password'));

        $user->group = $request->get('group');
        $user->status = $request->get('status');
        $user->country_id = $request->get('country_id');
        $user->description = $request->get('description');

        //$user->update();
        $user->save();

        return redirect()->route('users.index')
                        ->with('success',__('messages.user_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
                        ->with('success',__('messages.user_deleted_successfully'));
    }
}
