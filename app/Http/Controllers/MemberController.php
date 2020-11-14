<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberCreateRequest;
use App\Http\Requests\MemberUpdateRequest;
use App\LoginAttempt;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('members.index')->with('members', Member::all());
    }

    public function edit(Request $request, $id)
    {
        $member = Member::find($id);

        if (!$member) {
            throw new \Exception('Invalid Member');
        }
        return view('members.edit')->with('member', $member);
    }

    public function update(MemberUpdateRequest $request)
    {
        $member = Member::find($request->key);
        $member->irc_name = $request->irc_name;
        $member->spoken_name = $request->spoken_name;
        $member->admin = $request->admin;
        $member->active = $request->active;

        if (isset($request->pin) && strlen($request->pin) === 4)
        {
            $member->hash = sha1($request->pin);
        }

        try {
            $member->save();
        } catch(\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->action('MemberController@index');
    }

    public function create()
    {
        return view('members.create');
    }

    public function doCreate(MemberCreateRequest $request)
    {
        $member = new \App\Member;
        $member->key = $request->key;
        $member->hash = sha1($request->pin);
        $member->irc_name = $request->irc_name;
        $member->spoken_name = $request->spoken_name;
        $member->admin = $request->admin;
        $member->active = $request->active;
        $member->added_by = Auth::user()->id;
        $member->last_login = Carbon::now('America/Chicago');
        $member->date_created = Carbon::now('America/Chicago');
        $member->save();

        return redirect()->action('MemberController@index');
    }

    public function alibi(Request $request, $key)
    {
        return LoginAttempt::where('key', $key)->orderBy('timestamp', 'desc')->get();
    }
}
