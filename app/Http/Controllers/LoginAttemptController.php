<?php

namespace App\Http\Controllers;

use App\LoginAttempt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\LoginAttemptRequest;

class LoginAttemptController extends Controller
{
    public function create(LoginAttemptRequest $request) {
        $login = new \App\LoginAttempt;
        $login->key = $request->key;
        $login->timestamp = Carbon::createFromTimeStamp($request->timestamp);
        $login->reason = $request->reason;
        $login->result = $request->result;

        return ['status' => $login->save()];
    }
}
