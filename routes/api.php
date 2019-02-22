<?php

use Illuminate\Http\Request;

use App\Teacher;
use App\Http\Resources\Teacher as TeacherResource;

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


/*
Route::get('teachers','TeacherController@index');
Route::get('teacher/{id}','TeacherController@show');
*/

/*
Route::get('/teacher', function () {
    return new TeacherResource(Teacher::find(1));
});*/


Route::get('/teacher/', function () {
    return new TeacherResource(Teacher::find(1));
});

/*
Route::get('/teachers', function () {
    return new TeacherResource(Teacher::all());
});*/
