<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return view('home');
});

Route::resource('posts','PostController');
Route::resource('categories','CategoryController');
Route::resource('events','EventController');
Route::resource('eventCategories','EventCategoryController');
Route::resource('eventVenues','EventVenueController');
Route::resource('teachers','TeacherController');
Route::resource('organizers','OrganizerController');
Route::resource('continents','ContinentController');
Route::resource('countries','CountryController');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Single post by slug
    Route::get('post/{slug}', 'PostController@postBySlug')->where('postBySlug', '[a-z]+');

// TODO - Da finire
Route::get('/blog', function () {
    $posts = App\Post::all();
    return view('posts.show', compact('post'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*
Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
*/

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
'\vendor\uniSharp\LaravelFilemanager\Lfm::routes()';
});
