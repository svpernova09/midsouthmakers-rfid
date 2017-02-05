<?php

namespace App\Console\Commands;

use App\LoginAttempt;
use App\Member;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ParseLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse Log File and store LoginAttempts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $log = storage_path('rfid.log');
        $handle = fopen($log, "r");
        // Truncate the table
        DB::table('login_attempts')->truncate();

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $array = explode('|', $line);

                // Parse Date
                $date = Carbon::createFromTimeStamp(strtotime($array[0]));

                // Get the user ID
                $entry = explode(' ', $array[1]);
                $member_key = trim(array_pop($entry));
                $member = Member::where('key', $member_key)->first();
                $reason = $entry[1];
                if ($member) {
                    $login = new LoginAttempt;
                    $login->key = $member_key;
                    $login->timestamp = $date;

                    if ($reason == 'granted') {
                        $login->reason = 'success';
                        $login->result = 'success';
                    } else {
                        $login->reason = 'failure';
                        $login->result = 'failure';
                    }
                    $login->save();
                }
            }
            fclose($handle);
        }
    }
}
