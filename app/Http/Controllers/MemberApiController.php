<?php

namespace App\Http\Controllers;

use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MemberApiController extends Controller
{
    public function index(Request $request)
    {
        $members = Cache::get('members', function () {
            $results = [
                'timestamp' => Carbon::now(),
                'members'   => Member::all(),
            ];

            Cache::put('members', $results, 10080);

            return $results;
        });

        return $members;
    }

    public function get(Request $request)
    {
        return Member::find($request->id);
    }
}
