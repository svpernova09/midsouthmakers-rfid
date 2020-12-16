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

        if(Cache::get('discord-x-ratelimit-reset', 1) >= 1) {
            $this->output->writeln('Getting All Discord Members');
            $response = Http::withHeaders([
                "Authorization" => "Bot {$token}",
                "Content-Type" => "application/x-www-form-urlencoded",
                "Accept" => "application/json",
            ])->get("https://discord.com/api/guilds/{$guild_id}/members?limit=1000");

            // Cache the rate limit headers
            $this->handleDiscordResponseHeaders($response);
            // decode response
            $users = json_decode($response->getBody()->getContents(), true);

            foreach($users as $user) {
                Cache::put('_discord_member_'.$user['user']['id'], $user, 86400); # cache for 24 hours
            }
        }
    }

    private function handleDiscordResponseHeaders($response):void
    {
        $headers = $response->headers();

        if(array_key_exists('x-ratelimit-reset', $headers)) {
            if(now()->timestamp < $headers['x-ratelimit-reset'][0])
            {
                $this->output->writeln("Caching discord-x-ratelimit-reset-timestamp to expire at {$headers['x-ratelimit-reset'][0]}");
                // rate limit resets in the future update the cache
                Cache::put(
                    'discord-x-ratelimit-reset-timestamp',
                    $headers['x-ratelimit-reset'][0],
                    $headers['x-ratelimit-reset'][0]
                );
            } else {
                $this->output->writeln('forget discord-x-ratelimit-reset-timestamp');
                Cache::forget('discord-x-ratelimit-reset-timestamp');
            }
        }

        if(array_key_exists('x-ratelimit-remaining', $headers)) {
            if(now()->timestamp < $headers['x-ratelimit-reset'][0])
            {
                $this->output->writeln("Caching discord-x-ratelimit-reset to expire at {$headers['x-ratelimit-reset'][0]}");
                // rate limit remaining in the future update the cache
                Cache::put(
                    'discord-x-ratelimit-reset',
                    $headers['x-ratelimit-remaining'][0],
                    $headers['x-ratelimit-reset'][0]
                );
            } else {
                $this->output->writeln('forget discord-x-ratelimit-reset');
                Cache::forget('discord-x-ratelimit-reset');
            }
        }
    }
}
