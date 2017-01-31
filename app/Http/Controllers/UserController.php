<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberConnectRequest;
use App\Member;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('users.index')->with('users', User::all());
    }
}
