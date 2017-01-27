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
        $handle = fopen($log, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $array = explode('|', $line);

                // Parse Date
                $date = Carbon::createFromTimeStamp(strtotime($array[0]));

                // Get the user ID
                $entry = explode(' ', $array[1]);
                $member_key = trim(array_pop($entry));
                $member = Member::find($member_key);

                if ($member)
                {
                    $log_entries[] = [
                        'date' => $date->toDayDateTimeString(),
                        'ircName' => $member->ircName,
                        'result' => $entry[1],
                    ];
                }
            }

            fclose($handle);

            return view('logviewer.index')->with('log_entries', array_reverse($log_entries));
        }
    }
}
