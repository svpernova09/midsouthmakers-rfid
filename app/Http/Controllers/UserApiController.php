<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserApiController extends Controller
{
    public function get(Request $request, $id)
    {
        return User::find($id);
    }
}
