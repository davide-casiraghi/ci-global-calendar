<?php

use Illuminate\Http\Request;

use App\Teacher;
use App\Http\Resources\Teacher as TeacherResource;

use App\Event;
use App\Http\Resources\Event as EventResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* Teachers */
    Route::get('/teacher/{id}', function ($id) {  // http://www.globalcalendar-laravel.it/api/teacher/33
        return new TeacherResource(Teacher::find($id));
    });

    Route::get('/teachers', function () {  // http://www.globalcalendar-laravel.it/api/teachers
        return TeacherResource::collection(Teacher::all());
    });

/* Events */
    Route::get('/event/{id}', function ($id) {
        return new EventResource(Event::find($id));
    });

    Route::get('/events', function () {
        return EventResource::collection(Event::all());
    });



/*
Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    //
});
https://readouble.com/laravel/5.7/en/routing.html
*/
