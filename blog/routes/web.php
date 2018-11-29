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

Route::group(
[
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
],
function()
{
	/** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/

    /* Homepage - Event Search*/
        Route::get('/', 'EventSearchController@index')->name('home');

    /* Resource Controllers */
        Route::resource('users','UserController');
        Route::resource('posts','PostController');
        //Route::resource('postTranslations','PostTranslationController');
        Route::get('/postTranslations/{postId}/{languageCode}/create', 'PostTranslationController@create');
        Route::get('/postTranslations/{postId}/{languageCode}/edit', 'PostTranslationController@edit');
        Route::post('/postTranslations/store', 'PostTranslationController@store')->name('postTranslations.store');
        Route::put('/postTranslations/update', 'PostTranslationController@update')->name('postTranslations.update');

        Route::resource('categories','CategoryController');
        Route::resource('events','EventController');
        Route::resource('eventCategories','EventCategoryController');
        Route::resource('eventVenues','EventVenueController');
        Route::resource('teachers','TeacherController');
        Route::resource('organizers','OrganizerController');
        Route::resource('continents','ContinentController');
        Route::resource('countries','CountryController');
        Route::resource('eventSearch','EventSearchController');
        Route::resource('backgroundImages','BackgroundImageController');


    // To populate the event repeat by month options
        Route::get('/event/monthSelectOptions', 'EventController@calculateMonthlySelectOptions');


    // Single post by slug
        Route::get('post/{slug}', 'PostController@postBySlug')->where('postBySlug', '[a-z]+');

    /* Authentication */
        Auth::routes();

    /* Report misuse*/
        Route::post('/misuse', 'EventController@reportMisuse')->name("events.misuse");
        Route::get('/misuse/thankyou', 'EventController@reportMisuseThankyou')->name("events.misuse-thankyou");

    /* Contact form to write to the administrator */
        Route::get('/contactTheAdministrator', 'AdministratorMailFormController@contactAdmin')->name("forms.contact-admin");


});

/** OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/







/*  Editor Filemanager */
    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    '\vendor\uniSharp\LaravelFilemanager\Lfm::routes()';

/* Tests / Temporary */
    //Route::get('/home', 'HomeController@index')->name('home');

    //Route::post('countries.search','CountryController');
    //Route::post('/countries/search', 'CountryController@index')->name('projects.update');
    //Route::get('/countries/search', 'CountryController@search');

    //Route::get('/search', 'HomeController@index')->name('home');

    /*Route::get('/', function () {
        //return view('welcome');
        return view('home');
    });*/

});
