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
        $member->irc_name = $request->irc_name;
        $member->spoken_name = $request->spoken_name;
        $member->admin = $request->admin;
        $member->active = $request->active;
        $member->added_by = \Auth::user()->id;
        $member->last_login = '';
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
