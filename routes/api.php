<?php
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

Route::middleware(['auth:api'])->group(function () {
    Route::post('/login-attempt', 'LoginAttemptController@create');
    Route::get('/members', 'MemberApiController@index');
    Route::get('/members/{id}', 'MemberApiController@get');
    Route::get('/users/{id}', 'UserApiController@get');
});