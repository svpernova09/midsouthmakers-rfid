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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/members', 'MemberController@index');
Route::get('/members/{key}/edit', 'MemberController@edit');
Route::post('/members/{key}', 'MemberController@update');
Route::get('/log-viewer', 'LogViewerController@index');