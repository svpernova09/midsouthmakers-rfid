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

Route::middleware('auth:api')->post('/login-attempt', 'LoginAttemptController@create');

Route::middleware('auth:api')->get('/members', 'MemberApiController@index');
Route::middleware('auth:api')->get('/members/{id}', 'MemberApiController@get');

Route::middleware('auth:api')->get('/users/{id}', 'UserApiController@get');

