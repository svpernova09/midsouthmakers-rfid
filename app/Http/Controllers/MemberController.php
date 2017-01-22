<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberUpdateRequest;
use App\Member;
use Illuminate\Http\RedirectResponse;


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

    public function edit($key)
    {
        $member = Member::find($key);

        return view('members.edit')->with('member', $member);
    }

    public function update(MemberUpdateRequest $request)
    {
        $member = Member::find($request->key);
        $member->ircName = $request->ircName;
        $member->spokenName = $request->spokenName;
        $member->isAdmin = $request->isAdmin;
        $member->isActive = $request->isActive;

        $member->save();

        return redirect()->action('MemberController@index');
    }
}
