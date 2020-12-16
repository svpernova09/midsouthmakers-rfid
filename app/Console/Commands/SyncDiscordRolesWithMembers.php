<?php

namespace App\Console\Commands;

use App\Member;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Spatie\WebhookServer\WebhookCall;

class SyncDiscordRolesWithMembers extends Command
{
    public $roles;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:discord:role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Discord Users / Members';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->roles = [
            "board" => "784609154165768203",
            "member" => "784606833456185346",
        ];
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // First we should update our Discord info Cache
        $this->call('sync:discord:info');

        // Members who have discord id & username
        $members = Member::whereHas('user', function($q){
            $q->whereNotNull('discord_id');
        })->get();

        foreach($members as $member) {
            $discord_user = Cache::get('_discord_member_'.$member->user->discord_id, []);

            if(array_key_exists('roles', $discord_user))
            {
                // If the user is an admin, and they don't have board role, set them as admin
                if($member->admin && !in_array($this->roles['board'], $discord_user["roles"], true)) {
                    $this->output->writeln("Setting {$member->irc_name} as an Admin.");
                    $this->setAdminRole($member);
                }

                // If the user is a active, and they don't have member role, set them as member
                if($member->active && !in_array($this->roles['member'], $discord_user["roles"], true)) {
                    $this->output->writeln("Setting {$member->irc_name} as a Member.");
                    $this->setMemberRole($member);
                }
            } else {
                $this->output->writeln("Member {$member->irc_name} didn't have any roles.");
                $this->output->writeln("Member: " . $member);
            }
        }
    }

    public function setMemberRole($member):void
    {
        $guild_id = config('services.discord.guild_id');
        $token = config('services.discord.bot_token');

        if(Cache::get('discord-x-ratelimit-reset', 1) >= 1) {
            $response = Http::withHeaders([
                "Authorization" => "Bot {$token}",
                "Content-Type" => "application/x-www-form-urlencoded",
                "Accept" => "application/json",
            ])->put("https://discord.com/api/guilds/{$guild_id}/members/{$member->user->discord_id}/roles/{$this->roles['member']}");

            // Cache the rate limit headers
            $this->handleDiscordResponseHeaders($response);
            $this->notifyDiscord($member, 'MM Member');
        }
    }

    public function setAdminRole($member):void
    {
        $guild_id = config('services.discord.guild_id');
        $token = config('services.discord.bot_token');

        if(Cache::get('discord-x-ratelimit-reset', 1) >= 1) {
            $response = Http::withHeaders([
                "Authorization" => "Bot {$token}",
                "Content-Type" => "application/x-www-form-urlencoded",
                "Accept" => "application/json",
            ])->put("https://discord.com/api/guilds/{$guild_id}/members/{$member->user->discord_id}/roles/{$this->roles['board']}");

            // Cache the rate limit headers
            $this->handleDiscordResponseHeaders($response);
            $this->notifyDiscord($member, 'Board Member');
        }
    }

    public function notifyDiscord($member, $role){
        $content = "{$member->irc_name} Added to {$role}";

        return WebhookCall::create()
                          ->url(config('services.discord.role_change_webhook_url'))
                          ->payload([
                              'username' => 'MM-RolePlayBot',
                              'avatar_url' => '',
                              'content' => $content,
                          ])
                          ->doNotSign()
                          ->dispatch();
    }

    private function handleUnknownDiscordUser($member)
    {
        $user = User::find($member->user->id);
        $user->discord_id = null;
        $user->discord_username = null;
        $user->save();
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
