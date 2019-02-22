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

Route::get('/teacher/{id}', function ($id) {
    return new TeacherResource(Teacher::find($id));
});

Route::get('/teachers', function () {
    return TeacherResource::collection(Teacher::all());
});

/*
Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    //
});
https://readouble.com/laravel/5.7/en/routing.html
*/
