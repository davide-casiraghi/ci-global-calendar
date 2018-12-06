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
        Route::get('/create-venue/modal/', 'EventVenueController@modal')->name('eventVenues.modal');
        Route::post('/create-venue/modal/', 'EventVenueController@storeFromModal')->name('eventVenues.storeFromModal');

        Route::resource('teachers','TeacherController');
            Route::get('/create-teacher/modal/', 'TeacherController@modal')->name('teachers.modal');
            Route::post('/create-teacher/modal/', 'TeacherController@storeFromModal')->name('teachers.storeFromModal');

        Route::resource('organizers','OrganizerController');
            Route::get('/create-organizer/modal/', 'OrganizerController@modal')->name('organizers.modal');
            Route::post('/create-organizer/modal/', 'OrganizerController@storeFromModal')->name('organizers.storeFromModal');

        Route::resource('continents','ContinentController');
        Route::resource('countries','CountryController');
        Route::resource('eventSearch','EventSearchController');
        Route::resource('backgroundImages','BackgroundImageController');

    // To populate the event repeat by month options
        Route::get('/event/monthSelectOptions', 'EventController@calculateMonthlySelectOptions');

    // Single post by slug
        Route::get('post/{slug}', 'PostController@postBySlug')->where('postBySlug', '[a-z]+');

    /* Authentication */
        //Auth::routes();
        // Authentication Routes... https://stackoverflow.com/questions/42336115/how-can-i-pass-variable-to-register-view
            Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
            Route::post('login', 'Auth\LoginController@login');
            Route::post('logout', 'Auth\LoginController@logout')->name('logout');

        // Registration Routes...
            Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
            Route::post('register', 'Auth\RegisterController@register');

        // Password Reset Routes...
            Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
            Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
            Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
            Route::post('password/reset', 'Auth\ResetPasswordController@reset');

        // Activate User
            Route::post('/user-activation/send', 'Auth\RegisterController@userActivationMailSend')->name("user-activation-send");
            Route::get('/verify-user/{code}', 'Auth\RegisterController@activateUser')->name('activate.user');

    /* Report misuse*/
        Route::post('/misuse', 'EventController@reportMisuse')->name("events.misuse");
        Route::get('/misuse/thankyou', 'EventController@reportMisuseThankyou')->name("events.misuse-thankyou");

    /* Mail to the event organizer */
        Route::post('/mailToOrganizer', 'EventController@mailToOrganizer')->name("events.organizer-message");
        Route::get('/mailToOrganizer/sent', 'EventController@mailToOrganizerSent')->name("events.organizer-message-sent");

    /* Contact form to write to the administrator */
        Route::get('/contactTheAdministrator', 'AdministratorMailFormController@contactAdmin')->name("forms.contact-admin");
        Route::post('/contactTheAdministrator/send', 'AdministratorMailFormController@contactAdminSend')->name("forms.contact-admin-send");
        Route::get('/contactTheAdministrator/thankyou', 'AdministratorMailFormController@contactAdminThankyou')->name("forms.contact-admin-thankyou");

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
