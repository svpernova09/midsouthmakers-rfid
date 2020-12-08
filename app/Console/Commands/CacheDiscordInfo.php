<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CacheDiscordInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:discord:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cache Discord Info';

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
     * @return int
     */
    public function handle()
    {
        $guild_id = config('services.discord.guild_id');
        $token = config('services.discord.bot_token');

        $response = Http::withHeaders([
            "Authorization" => "Bot {$token}",
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ])->get("https://discord.com/api/guilds/{$guild_id}/members?limit=1000");

        $users = json_decode($response->getBody()->getContents(), true);

        foreach($users as $user) {
            Cache::put('_discord_member_'.$user['user']['id'], $user, 86400); # cache for 24 hours
        }
    }
}
