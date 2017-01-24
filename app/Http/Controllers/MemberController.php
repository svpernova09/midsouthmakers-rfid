<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberCreateRequest;
use App\Http\Requests\MemberUpdateRequest;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


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

    public function edit(Request $request, $key)
    {
        $member = Member::where('key', $key)->first();

        if (!$member) {
            throw new \Exception('Invalid key');
        }
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

    public function create()
    {
        return view('members.create');
    }

    public function doCreate(MemberCreateRequest $request)
    {
        $member = new \App\Member;
        $member->key = $this->cleanKey($request->key);
        $member->hash = $this->hashPin($request->pin);
        $member->ircName = $request->ircName;
        $member->spokenName = $request->spokenName;
        $member->isAdmin = $request->isAdmin;
        $member->isActive = $request->isActive;
        $member->addedBy = 12345;
        $member->lastLogin = '';
        $member->dateCreated = Carbon::now('America/Chicago')->timestamp;
        $member->save();

        return redirect()->action('MemberController@index');
    }

    public function hashPin($pin)
    {
        $salt = '$1$' . substr(microtime(),0,8);

        return crypt($pin, $salt);
    }

    public function cleanKey($key){
        $int_key = intval($key);
        $clean_key = $int_key & 0x00FFFFFF;

        return $clean_key;
    }
}
