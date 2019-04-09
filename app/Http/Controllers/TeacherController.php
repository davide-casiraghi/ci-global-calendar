<?php

namespace App\Http\Controllers;

use App\User;
use App\Event;
use Validator;
use App\Country;
use App\Teacher;
use Carbon\Carbon;
use App\EventCategory;
use App\EventRepetition;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class TeacherController extends Controller
{
    /* Restrict the access to this resource just to logged in users except show and index view */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'teacherBySlug']]);
    }

    /***************************************************************************/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countries = Country::orderBy('countries.name')->pluck('name', 'id');

        // Get the countries with active teachers - BUG! IF I CACHE JUST A PART OF THE COUNTRIES WHEN I INSERT A NEW TEACHER WITH A COUNTRY THAT IS NOT IN THE CACHE I GET AN ERROR WHEN I'M BACK TO THE INDEX (eg.no index error)
        /*    $cacheExpireTime = 900; // Set the duration time of the cache (15 min - 900sec)
            $countries = Cache::remember('teachers_countries', cacheExpireTime, function () {
                return DB::table('countries')
                    ->join('teachers', 'countries.id', '=', 'teachers.country_id')
                    ->orderBy('countries.name')
                    ->pluck('countries.name', 'countries.id');
            });*/

        // Search keywords
        $searchKeywords = $request->input('keywords');
        $searchCountry = $request->input('country_id');

        // To show just the teachers created by the the user - If admin or super admin is set to null show all the teachers
        $authorUserId = ($this->getLoggedAuthorId()) ? $this->getLoggedAuthorId() : null; // if is 0 (super admin or admin) it's setted to null to avoid include it in the query

        // To retrieve all the teachers when the route is teacher.directory, we set the logged user id to null
        if (Route::currentRouteName() == 'teachers.directory') {
            $authorUserId = null;
        }

        if ($searchKeywords || $searchCountry) {
            $teachers = DB::table('teachers')
                ->when($authorUserId, function ($query, $authorUserId) {
                    return $query->where('created_by', $authorUserId);
                })
                ->when($searchKeywords, function ($query, $searchKeywords) {
                    return $query->where('name', $searchKeywords)->orWhere('name', 'like', '%'.$searchKeywords.'%');
                })
                ->when($searchCountry, function ($query, $searchCountry) {
                    return $query->where('country_id', '=', $searchCountry);
                })
                ->orderBy('name')
                ->paginate(20);
        } else {
            $teachers = Teacher::
            when($authorUserId, function ($query, $authorUserId) {
                return $query->where('created_by', $authorUserId);
            })
            ->orderBy('name')
            ->paginate(20);
        }

        return view('teachers.index', compact('teachers'))
            ->with('i', (request()->input('page', 1) - 1) * 20)
            ->with('countries', $countries)
            ->with('searchKeywords', $searchKeywords)
            ->with('searchCountry', $searchCountry)
            ->with('loggedUser', $authorUserId);
    }

    /***************************************************************************/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::getCountries();
        $users = User::pluck('name', 'id');
        $authorUserId = $this->getLoggedUser();

        return view('teachers.create')
            ->with('countries', $countries)
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
        $validator = $this->teachersValidator($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $teacher = new Teacher();
        $this->saveOnDb($request, $teacher);

        return redirect()->route('teachers.index')
                        ->with('success', __('messages.teacher_added_successfully'));
    }

    /***************************************************************************/

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {

        // Get the name of the teacher's country
        $country = Country::select('name')
            ->where('id', $teacher->country_id)
            ->first();

        $cacheExpireTime = 900; // Set the duration time of the cache (15 min - 900sec)
        $eventCategories = Cache::remember('categories', $cacheExpireTime, function () {
            return EventCategory::orderBy('name')->pluck('name', 'id');
        });

        // Get for each event the first event repetition in the near future (JUST THE QUERY)
        date_default_timezone_set('Europe/Rome');
        $searchStartDate = date('Y-m-d', time()); // search start from today's date
        $lastestEventsRepetitionsQuery = EventRepetition::getLastestEventsRepetitionsQuery($searchStartDate, null);

        // Get the events where this teacher is teaching to
        //DB::enableQueryLog();
        $eventsTeacherWillTeach = $teacher->events()
                                              ->select('events.title', 'events.category_id', 'events.slug', 'events.sc_venue_name', 'events.sc_country_name', 'events.sc_city_name', 'events.sc_teachers_names', 'event_repetitions.start_repeat', 'event_repetitions.end_repeat')
                                              ->joinSub($lastestEventsRepetitionsQuery, 'event_repetitions', function ($join) {
                                                  $join->on('events.id', '=', 'event_repetitions.event_id');
                                              })
                                              ->orderBy('event_repetitions.start_repeat', 'asc')
                                              ->get();
        //dd(DB::getQueryLog());
        //dd($eventsTeacherWillTeach);

        return view('teachers.show', compact('teacher'))
            ->with('country', $country)
            ->with('eventCategories', $eventCategories)
            ->with('eventsTeacherWillTeach', $eventsTeacherWillTeach);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        $authorUserId = $this->getLoggedAuthorId();
        $users = User::pluck('name', 'id');
        $countries = Country::getCountries();

        return view('teachers.edit', compact('teacher'))
            ->with('countries', $countries)
            ->with('users', $users)
            ->with('authorUserId', $authorUserId);
    }

    /***************************************************************************/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        // Validate form datas
        $validator = $this->teachersValidator($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $this->saveOnDb($request, $teacher);

        return redirect()->route('teachers.index')
                        ->with('success', __('messages.teacher_updated_successfully'));
    }

    /***************************************************************************/

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->route('teachers.index')
                        ->with('success', __('messages.teacher_deleted_successfully'));
    }

    /***************************************************************************/

    /**
     * Save the record on DB.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function saveOnDb($request, $teacher)
    {
        $teacher->name = $request->get('name');
        //$teacher->bio = $request->get('bio');
        $teacher->bio = clean($request->get('bio'));
        $teacher->country_id = $request->get('country_id');
        $teacher->year_starting_practice = $request->get('year_starting_practice');
        $teacher->year_starting_teach = $request->get('year_starting_teach');
        $teacher->significant_teachers = $request->get('significant_teachers');

        // Teacher profile picture upload
        if ($request->file('profile_picture')) {
            $imageFile = $request->file('profile_picture');
            $imageName = $imageFile->hashName();
            $imageSubdir = 'teachers_profile';
            $imageWidth = '968';
            $thumbWidth = '300';

            $this->uploadImageOnServer($imageFile, $imageName, $imageSubdir, $imageWidth, $thumbWidth);
            $teacher->profile_picture = $imageName;
        } else {
            $teacher->profile_picture = $request->profile_picture;
        }

        $teacher->website = $request->get('website');
        $teacher->facebook = $request->get('facebook');

        $teacher->created_by = \Auth::user()->id;
        if (! $teacher->slug) {
            $teacher->slug = Str::slug($teacher->name, '-').'-'.rand(10000, 100000);
        }

        $teacher->save();
    }

    /***************************************************************************/

    /**
     * Open a modal in the event view when create teachers is clicked.
     *
     * @return \Illuminate\Http\Response
     */
    public function modal()
    {
        $countries = Country::getCountries();

        return view('teachers.modal')->with('countries', $countries);
    }

    /***************************************************************************/

    /**
     * Store a newly created teacher from the create event view modal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromModal(Request $request)
    {
        $teacher = new Teacher();

        request()->validate([
            'name' => 'required',
        ]);

        $this->saveOnDb($request, $teacher);

        return redirect()->back()->with('message', __('messages.teacher_added_successfully'));
        //return redirect()->back()->with('message', __('auth.successfully_registered'));
        //return true;
    }

    /***************************************************************************/

    /**
     * Return the teacher by SLUG. (eg. http://websitename.com/teacher/xxxx).
     *
     * @param  \App\Teacher  $post
     * @return \Illuminate\Http\Response
     */
    public function teacherBySlug($slug)
    {
        $teacher = Teacher::
                where('slug', $slug)
                ->first();

        return $this->show($teacher);
    }

    /***************************************************************************/

    /**
     * Return the validator with all the defined constraint.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Validation\Validator
     */
    public function teachersValidator($request)
    {
        $maxYear = Carbon::now()->year;

        $rules = [
            'name' => 'required',
            'year_starting_practice' => 'required|integer|min:1972|max:'.($maxYear),
            'year_starting_teach' => 'required|integer|min:1972|max:'.($maxYear),
            'facebook' => 'nullable|url',
            'website' => 'nullable|url',
            // 'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png|max:3000',   // BUG create problems to validate on edit. Fix this after the rollout
            // 'required_with:end_page|integer|min:1|digits_between: 1,5',  // https://stackoverflow.com/questions/32036882/laravel-validate-an-integer-field-that-needs-to-be-greater-than-another
        ];
        if ($request->hasFile('profile_picture')) {
            $rules['profile_picture'] = 'nullable|image|mimes:jpeg,jpg,png|max:5000';
        }
        $messages = [
            'facebook.url' => 'The facebook link is invalid. It should start with https://',
            'website.url' => 'The website link is invalid. It should start with https://',
            'profile_picture.max' => 'The maximum image size is 5MB. If you need to resize it you can use: www.simpleimageresizer.com',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        return $validator;
    }
}
