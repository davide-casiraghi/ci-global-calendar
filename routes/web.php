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
    Route::get('/activate-user-from-backend/{userId}', 'Auth\RegisterController@activateUserFromBackend')->name('activate.user.from.backend');

    /* Contact form to write to administrator, project-manager, webmaster */
    Route::get('/contactForm/compose/{recipient}', 'ContactFormController@contactForm')->name('forms.contactform');
    Route::post('/contactForm/send', 'ContactFormController@contactFormSend')->name('forms.contactform-send');
    Route::get('/contactForm/thankyou', 'ContactFormController@contactFormThankyou')->name('forms.contactform-thankyou');

    /* Mass mailing */
    Route::get('/massMailing/compose/', 'MassMailingController@massMailing')->name('forms.massmailing');
    Route::post('/massMailing/send', 'MassMailingController@massMailingSend')->name('forms.massmailing-send');
    Route::get('/massMailing/thankyou', 'MassMailingController@massMailingThankyou')->name('forms.massmailing-thankyou');

    /* Users export */
    Route::get('/usersExport/', 'UsersExportController@show')->name('users-export-show');
    Route::post('/usersExport/export', 'UsersExportController@export')->name('users-export-export');
    Route::get('/usersExport/exported', 'UsersExportController@exported')->name('users-export-exported');
    
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
