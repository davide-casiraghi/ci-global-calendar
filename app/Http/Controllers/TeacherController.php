<?php

namespace App\Http\Controllers;

use App\Teacher;
use App\Country;
use App\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use Validator;

class TeacherController extends Controller
{
    /* Restrict the access to this resource just to logged in users except show and index view */
    public function __construct(){
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    /***************************************************************************/
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $countries = Country::pluck('name', 'id');

        $searchKeywords = $request->input('keywords');
        $searchCountry = $request->input('country_id');

        // To retrieve just the teachers created by this user - We will compare it with the created_by value in the teacher table
            $loggedUser = $this->getLoggedAuthorId();  
        
        // To retrieve all the teachers when the route is teacher.directory, we set the logged user id to null
            if(Route::currentRouteName()=="teachers.directory")
                $loggedUser->id = null;

        if ($searchKeywords||$searchCountry){
            $teachers = DB::table('teachers')
                ->when($loggedUser->id, function ($query, $loggedUserId) {
                    return $query->where('created_by', $loggedUserId);
                })
                ->when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('name', $searchKeywords)->orWhere('name', 'like', '%' . $searchKeywords . '%');
                })
                ->when($searchCountry, function ($query, $searchCountry) {
                    return $query->where('country_id', '=', $searchCountry);
                })
                ->paginate(20);
        }
        else
            $teachers = Teacher::latest()
            ->when($loggedUser->id, function ($query, $loggedUserId) {
                return $query->where('created_by', $loggedUserId);
            })
            ->paginate(20);

        return view('teachers.index',compact('teachers'))
            ->with('i', (request()->input('page', 1) - 1) * 20)
            ->with('countries', $countries)
            ->with('searchKeywords',$searchKeywords)
            ->with('searchCountry',$searchCountry)
            ->with('loggedUser',$loggedUser);
    }

    /***************************************************************************/
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $countries = Country::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $authorUserId = $this->getLoggedAuthorId();

        return view('teachers.create')
            ->with('countries', $countries)
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
                'year_starting_practice' => 'required',
                'year_starting_teach' => 'required',
            ]);
            
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
        
        $teacher = new Teacher();

        $this->saveOnDb($request, $teacher);

        return redirect()->route('teachers.index')
                        ->with('success',__('messages.teacher_added_successfully'));
    }
    
    /***************************************************************************/
    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher){
        $country = Country::select('name')
        ->where('id', $teacher->country_id)
        ->first();
        
        return view('teachers.show',compact('teacher'))
            ->with('country', $country);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher){
        $authorUserId = $this->getLoggedAuthorId();
        $users = User::pluck('name', 'id');
        $countries = Country::pluck('name', 'id');

        return view('teachers.edit',compact('teacher'))
            ->with('countries', $countries)
            ->with('users', $users)
            ->with('authorUserId',$authorUserId);
    }

    /***************************************************************************/
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

        //$teacher->update($request->all());
        $this->saveOnDb($request, $teacher);

        return redirect()->route('teachers.index')
                        ->with('success',__('messages.teacher_updated_successfully'));
    }

    /***************************************************************************/
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher){
        $teacher->delete();
        return redirect()->route('teachers.index')
                        ->with('success',__('messages.teacher_deleted_successfully'));
    }

    /***************************************************************************/
    /**
     * Save the record on DB
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
     public function saveOnDb($request, $teacher){
        
         $teacher->name = $request->get('name');
         //$teacher->bio = $request->get('bio');
         $teacher->bio = clean($request->get('bio'));
         $teacher->country_id = $request->get('country_id');
         $teacher->year_starting_practice = $request->get('year_starting_practice');
         $teacher->year_starting_teach = $request->get('year_starting_teach');
         $teacher->significant_teachers = $request->get('significant_teachers');

         // Teacher profile picture upload
             if ($request->file('profile_picture')){
                 $imageFile = $request->file('profile_picture');
                 $imageName = $imageFile->hashName();
                 $imageSubdir = "teachers_profile";
                 $imageWidth = "968";
                 $thumbWidth = "345";
                 
                 $this->uploadImageOnServer($imageFile, $imageName, $imageSubdir, $imageWidth, $thumbWidth);    
                 $teacher->profile_picture = $imageName;
            }

         $teacher->website = $request->get('website');
         $teacher->facebook = $request->get('facebook');

         $teacher->created_by = \Auth::user()->id;
         $teacher->slug = str_slug($teacher->name, '-')."-".rand(10000, 100000);

         $teacher->save();
     }

    /***************************************************************************/
    /**
     * Open a modal in the event view when create teachers is clicked
     *
     * @return view
     */
    public function modal(){
        $countries = Country::pluck('name', 'id');
        return view('teachers.modal')->with('countries', $countries);
    }

    /***************************************************************************/
    /**
     * Store a newly created teacher from the create event view modal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromModal(Request $request){
        $teacher = new Teacher();
        
        request()->validate([
            'name' => 'required'
        ]);

        $this->saveOnDb($request, $teacher);

        return redirect()->back()->with('message', __('messages.teacher_added_successfully'));
        //return redirect()->back()->with('message', __('auth.successfully_registered'));
        //return true;
    }

    /***************************************************************************/
    /**
     * Return the teacher by SLUG. (eg. http://websitename.com/teacher/xxxx)
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */

    public function teacherBySlug($slug){
        
        $teacher = Teacher::
                where('slug', $slug)
                ->first();
        return $this->show($teacher);
    }

}
