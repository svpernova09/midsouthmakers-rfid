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
        $stats = [];
        $log = storage_path('rfid.log');
        $last_modified =  Carbon::createFromTimestamp(filemtime($log), 'America/Chicago')->toDateTimeString();
        $log_entries = LoginAttempt::with('member')->orderBy('timestamp', 'desc')->paginate(25);

        return view('logviewer.index')
            ->with('log_entries', $log_entries)
            ->with('last_modified', $last_modified)
            ->with('stats', $stats);
    }
}
