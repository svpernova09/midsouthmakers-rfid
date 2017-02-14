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

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/members', 'MemberController@index');
Route::post('/members', 'MemberController@doCreate');
Route::get('/members/create', 'MemberController@create');
Route::get('/members/{key}/edit', 'MemberController@edit');
Route::post('/members/{key}', 'MemberController@update');
Route::get('/log-viewer', 'LogViewerController@index');
Route::get('/users', 'UserController@index');
Route::get('/member-connect', 'HomeController@memberConnect');
Route::post('/member-connect', 'HomeController@doMemberConnect');
Route::get('/sign-waiver', 'WaiverController@index');
Route::post('/sign-waiver', 'WaiverController@saveIndividualWaiver');
Route::get('/sign-waiver/individual', 'WaiverController@individual');
Route::get('/sign-waiver/dependent', 'WaiverController@dependent');
Route::get('/waivers/admin', 'WaiverController@admin');
