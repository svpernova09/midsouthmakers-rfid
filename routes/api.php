<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/members', function (Request $request) {
    $members = Cache::get('members', function () {
        $results =  [
            'timestamp' => \Carbon\Carbon::now(),
            'members' => \App\Member::all(),
        ];

        \Cache::put('members', $results, 10080);

        return $results;
    });

    return $members;
});

Route::middleware('auth:api')->get('/members/{id}', function (Request $request) {
    return \App\Member::find($request->id);
});

Route::middleware('auth:api')->get('/users/{id}', function (Request $request) {
    return \App\User::find($request->id);
});

Route::middleware('auth:api')->get('/fresh-and-clean', function (Request $request) {
    return ['status' => 'NYI'];
});

Route::middleware('auth:api')->post('/login-attempt', 'LoginAttemptController@create');
