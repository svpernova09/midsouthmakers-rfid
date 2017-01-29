<?php

namespace App\Http\Controllers;

use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogViewerController extends Controller
{
    public function index()
    {
        $log_entries = [];
        $log = storage_path('rfid.log');
        $last_modified =  Carbon::createFromTimestamp(filemtime($log), 'America/Chicago')->toDateTimeString();

        $handle = fopen($log, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $array = explode('|', $line);

                // Parse Date
                $date = Carbon::createFromTimeStamp(strtotime($array[0]));

                // Get the user ID
                $entry = explode(' ', $array[1]);
                $member_key = trim(array_pop($entry));
                $member = Member::where('key', $member_key)->first();

                if ($member)
                {
                    $log_entries[] = [
                        'date' => $date->toDayDateTimeString(),
                        'irc_name' => $member->irc_name,
                        'result' => $entry[1],
                    ];
                }
            }

            fclose($handle);

            return view('logviewer.index')
                ->with('log_entries', array_reverse($log_entries))
                ->with('last_modified', $last_modified);
        }
    }
}
