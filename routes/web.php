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
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
],
function () {
    /* ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/

    /* Homepage - Event Search */
    Route::get('/', 'EventSearchController@index')->name('home');
    Route::resource('eventSearch', 'EventSearchController');
    Route::get('/eventSearch#dataarea', 'EventSearchController@index');

    /* Users */
    Route::resource('users', 'UserController');

    /* Menus */
    //Route::resource('menus', 'MenuController');

    /* Menu Items */
    /*Route::get('/menuItems/index/{id}', 'MenuItemController@index')->name('menuItemsIndex');
    Route::resource('menuItems', 'MenuItemController');
    Route::put('/menuItem/updateOrder', 'MenuItemController@updateOrder')->name('menuItems.updateOrder');
*/
    /* Menu Items Translations */
    /*Route::get('/menuItemTranslations/{menuItemId}/{languageCode}/{menuId}/create', 'MenuItemTranslationController@create');
    Route::get('/menuItemTranslations/{menuItemId}/{languageCode}/{menuId}/edit', 'MenuItemTranslationController@edit');
    Route::post('/menuItemTranslations/store', 'MenuItemTranslationController@store')->name('menuItemTranslations.store');
    Route::put('/menuItemTranslations/update', 'MenuItemTranslationController@update')->name('menuItemTranslations.update');
    Route::delete('/menuItemTranslations/destroy/{menuItemTranslationId}/{selectedMenuId}', 'MenuItemTranslationController@destroy')->name('menuItemTranslations.destroy');
*/

    /* Post Categories */
    Route::resource('categories', 'CategoryController');

    /* Category Translations */
    Route::get('/categoryTranslations/{categoryId}/{languageCode}/create', 'CategoryTranslationController@create');
    Route::get('/categoryTranslations/{categoryId}/{languageCode}/edit', 'CategoryTranslationController@edit');
    Route::post('/categoryTranslations/store', 'CategoryTranslationController@store')->name('categoryTranslations.store');
    Route::put('/categoryTranslations/update', 'CategoryTranslationController@update')->name('categoryTranslations.update');
    Route::delete('/categoryTranslations/destroy/{categoryTranslationId}', 'CategoryTranslationController@destroy')->name('categoryTranslations.destroy');

    /* Posts */
    Route::resource('posts', 'PostController');
    Route::get('/post/{slug}', 'PostController@postBySlug')->where('postBySlug', '[a-z]+');

    /* Posts Translations */
    Route::get('/postTranslations/{postId}/{languageCode}/create', 'PostTranslationController@create');
    Route::get('/postTranslations/{postId}/{languageCode}/edit', 'PostTranslationController@edit');
    Route::post('/postTranslations/store', 'PostTranslationController@store')->name('postTranslations.store');
    Route::put('/postTranslations/update', 'PostTranslationController@update')->name('postTranslations.update');
    Route::delete('/postTranslations/destroy/{postTranslationId}', 'PostTranslationController@destroy')->name('postTranslations.destroy');

    /* Event Categories */
    //Route::resource('eventCategories', 'EventCategoryController');

    /* Event Categories Translations */
    /*Route::get('/eventCategoryTranslations/{eventCategoryId}/{languageCode}/create', 'EventCategoryTranslationController@create');
    Route::get('/eventCategoryTranslations/{eventCategoryId}/{languageCode}/edit', 'EventCategoryTranslationController@edit');
    Route::post('/eventCategoryTranslations/store', 'EventCategoryTranslationController@store')->name('eventCategoryTranslations.store');
    Route::put('/eventCategoryTranslations/update', 'EventCategoryTranslationController@update')->name('eventCategoryTranslations.update');
    Route::delete('/eventCategoryTranslations/destroy/{eventCategoryTranslationId}', 'EventCategoryTranslationController@destroy')->name('eventCategoryTranslations.destroy');
*/
    /* Events */
    /*Route::resource('events', 'EventController');
    Route::get('/event/monthSelectOptions/', 'EventController@calculateMonthlySelectOptions');  // To populate the event repeat by month options
    Route::get('/event/{slug}', 'EventController@eventBySlug')->where('eventBySlug', '[a-z]+')->name('events.eventBySlug');
    Route::get('/event/{slug}/{repeatition}', 'EventController@eventBySlugAndRepetition')->where('eventBySlugAndRepetition', '[a-z]+', '[0-9]+');
*/
    /* Report Misuse */
    /*Route::post('/misuse', 'EventController@reportMisuse')->name('events.misuse');
    Route::get('/misuse/thankyou', 'EventController@reportMisuseThankyou')->name('events.misuse-thankyou');
*/
    /* Mail to the event organizer */
    //Route::post('/mailToOrganizer', 'EventController@mailToOrganizer')->name('events.organizer-message');
    //Route::get('/mailToOrganizer/sent', 'EventController@mailToOrganizerSent')->name('events.organizer-sent');

    /* Event Venues */
    /*Route::resource('eventVenues', 'EventVenueController');
    Route::get('/create-venue/modal/', 'EventVenueController@modal')->name('eventVenues.modal');
    Route::post('/create-venue/modal/', 'EventVenueController@storeFromModal')->name('eventVenues.storeFromModal');
    */

    /* Teachers */
    /*Route::resource('teachers', 'TeacherController');
    Route::get('/create-teacher/modal/', 'TeacherController@modal')->name('teachers.modal');
    Route::post('/create-teacher/modal/', 'TeacherController@storeFromModal')->name('teachers.storeFromModal');
    Route::get('/teachersDirectory/', 'TeacherController@index')->name('teachers.directory');
    Route::get('/teacher/{slug}', 'TeacherController@teacherBySlug')->where('teacherBySlug', '[a-z]+');
*/
    /* Organizers */
    /*Route::resource('organizers', 'OrganizerController');
    Route::get('/create-organizer/modal/', 'OrganizerController@modal')->name('organizers.modal');
    Route::post('/create-organizer/modal/', 'OrganizerController@storeFromModal')->name('organizers.storeFromModal');
    Route::get('/organizer/{slug}', 'OrganizerController@organizerBySlug')->where('organizerBySlug', '[a-z]+');
*/
    /* Continents and Countries */
    //Route::resource('continents', 'ContinentController');
    //Route::resource('countries', 'CountryController');

    /* Background images */
    Route::resource('backgroundImages', 'BackgroundImageController');

    /* Donation Offers */
    Route::get('/donationOffersPublic', 'DonationOfferController@index')->defaults('page_kind', 'public');
    Route::resource('donationOffers', 'DonationOfferController');
    //Route::get('/donationOffersPublic/', 'DonationOfferController@indexPublic')->name('donationOffers.public');

    /* Authentication */
    //Auth::routes();
    // Authentication Routes... https://stackoverflow.com/questions/42336115/how-can-i-pass-variable-to-register-view
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register')->name('register');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    // Activate User
    Route::post('/user-activation/send', 'Auth\RegisterController@userActivationMailSend')->name('user-activation-send');
    Route::get('/verify-user/{code}', 'Auth\RegisterController@activateUser')->name('activate.user');

    /* Contact form to write to administrator, project-manager, webmaster */
    Route::get('/contactForm/compose/{recipient}', 'ContactFormController@contactForm')->name('forms.contactform');
    Route::post('/contactForm/send', 'ContactFormController@contactFormSend')->name('forms.contactform-send');
    Route::get('/contactForm/thankyou', 'ContactFormController@contactFormThankyou')->name('forms.contactform-thankyou');

    /* Statistics */
    Route::get('/statistics', 'StatisticsController@index')->name('statistics');
    Route::get('/statistics/update', 'StatisticsController@store');
});

/* OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/

    /*  Editor Filemanager */
        Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
            '\vendor\uniSharp\LaravelFilemanager\Lfm::routes()';
        });

    /* Sitemap */
        Route::get('/sitemap', 'SitemapController@index');
        Route::get('/sitemap/posts', 'SitemapController@posts');
        Route::get('/sitemap/events', 'SitemapController@events');
        Route::get('/sitemap/teachers', 'SitemapController@teachers');
        Route::get('/sitemap.xml', 'SitemapController@index');

    /* Iframe for regional websites */
        Route::get('/eventSearch/country/{code}', 'EventSearchController@EventsListByCountry');
