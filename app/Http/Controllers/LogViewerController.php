<?php

namespace App\Http\Controllers;

use App\LoginAttempt;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogViewerController extends Controller
{
    public function index()
    {
        $log_entries = LoginAttempt::with('member')
                                   ->orderBy('timestamp', 'desc')
                                   ->take(1000)
                                   ->get();

        return view('logviewer.index')->with('log_entries', $log_entries);
    }
}
