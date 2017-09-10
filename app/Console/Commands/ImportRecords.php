<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Users from CSV';

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
        $users = [];
        if (($handle = fopen(storage_path('users.csv'), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $users[] = $data;
            }
            fclose($handle);
        }

        foreach($users as $user) {
            $member = new \App\Member;
            $member->key = $user[0];
            $member->hash = $user[1];
            $member->irc_name = $user[2];
            $member->spoken_name = $user[3];
            $member->added_by = 1;
            $member->date_created = $user[5] ? $user[5] : time();
            $member->last_login = $user[7];
            $member->admin = $user[6];
            $member->active = $user[8];
            $member->save();
        }
    }
}
