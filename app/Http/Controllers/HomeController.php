<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberConnectRequest;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Auth::user()->members;

        return view('home')->with('members', $members);
    }

    public function memberConnect()
    {
        return view('users.member-connect');
    }

    public function doMemberConnect(MemberConnectRequest $request)
    {
        $cache_key = 'user_connect_attempts_'.Auth::user()->id;
        $this->checkCache($cache_key);

        $member = Member::where('key', $request->key)->where('hash', sha1($request->pin))->with('user')->first();

        if (Cache::get($cache_key) > 4) {
            return view('users.member-connect')->withErrors('You have tried too many times to connect this key.');
        }

        if ($member === null) {
            Cache::increment($cache_key);

            return view('users.member-connect')->withErrors('Could not connect that key.');
        }

        if ($member->user_id !== null) {
            return view('users.member-connect')->withErrors('Key has already been connected.');
        }

        if ($member && $member->user_id === null) {
            $member->user_id = Auth::user()->id;
            $member->save();
            Cache::pull($cache_key, 1, 1000);

            return response()->redirectToAction('HomeController@index');
        }

        Cache::increment($cache_key);

        return view('users.member-connect')->withErrors('Could not connect that key.');
    }

    public function checkCache($cache_key)
    {
        Cache::remember($cache_key, 1000, function () use ($cache_key) {
            if (! Cache::has($cache_key)) {
                Cache::put($cache_key, '1', 1000);
            }
        });
    }
}
