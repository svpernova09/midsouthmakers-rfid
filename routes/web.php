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

use App\Http\Controllers\Auth\DiscordAuthController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::post('/authorize/discord', [DiscordAuthController::class, 'sendAuthEmail']);
Route::get('/authorize/discord/{hash}', [DiscordAuthController::class, 'attemptVerify'])->middleware('auth')->name('auth.discord.verify');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/members', 'MemberController@index');
Route::post('/members', 'MemberController@doCreate');
Route::get('/members/create', 'MemberController@create');
Route::get('/members/{key}/alibi', 'MemberController@alibi');
Route::get('/members/{key}/edit', 'MemberController@edit');
Route::post('/members/{key}', 'MemberController@update');
Route::get('/log-viewer', 'LogViewerController@index')->middleware('admin');
Route::get('/users', 'UserController@index');
Route::get('/member-connect', 'HomeController@memberConnect');
Route::post('/member-connect', 'HomeController@doMemberConnect');
Route::get('/sign-waiver', 'WaiverController@index');
Route::post('/sign-waiver', 'WaiverController@saveIndividualWaiver');
Route::get('/sign-waiver/individual', 'WaiverController@individual');
Route::get('/sign-waiver/dependent', 'WaiverController@dependent');
Route::get('/waivers/admin', 'WaiverController@admin')->middleware('admin');
Route::get('/waivers/download/{waiver_id}', 'WaiverController@downloadWaiver')->middleware('admin');
