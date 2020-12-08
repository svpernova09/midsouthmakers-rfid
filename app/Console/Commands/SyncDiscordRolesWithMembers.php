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
            "member" => "784609154165768203",
        ];
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Members who have discord id & username
        $members = Member::whereHas('user', function($q){
            $q->whereNotNull('discord_id');
        })->get();

        foreach($members as $member) {
            $discord_user =  $this->getDiscordUser($member);

            if($member->admin && !in_array($this->roles['board'], $discord_user["roles"], true)) {
                $this->setAdminRole($member);
            }

            if($member->active && !in_array($this->roles['member'], $discord_user["roles"], true)) {
                $this->setMemberRole($member);
            }
//            $this->output->writeln('Sleeping 15 seconds');
//            sleep(15);
        }
    }

    public function setMemberRole($member):void
    {
        $guild_id = config('services.discord.guild_id');
        $token = config('services.discord.bot_token');

        $response = Http::withHeaders([
            "Authorization" => "Bot {$token}",
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ])->put("https://discord.com/api/guilds/{$guild_id}/members/{$member->user->discord_id}/roles/{$this->roles['board']}");
        $this->notifyDiscord($member, 'MM Member');
    }

    public function setAdminRole($member):void
    {
        $guild_id = config('services.discord.guild_id');
        $token = config('services.discord.bot_token');

        $response = Http::withHeaders([
            "Authorization" => "Bot {$token}",
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ])->put("https://discord.com/api/guilds/{$guild_id}/members/{$member->user->discord_id}/roles/{$this->roles['member']}");
        $this->notifyDiscord($member, 'Board Member');
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

    public function getDiscordUser($member)
    {
        // Before we ask Discord check if we have cached this data yet
        $discord_user = Cache::get('_discord_member_'.$member->user->discord_id, false);

        if(!$discord_user) {
            $this->output->writeln('Sleep for 30 seconds to buy some Discord API time');
            sleep(30);

            $guild_id = config('services.discord.guild_id');
            $token = config('services.discord.bot_token');

            $response = Http::withHeaders([
                "Authorization" => "Bot {$token}",
                "Content-Type" => "application/x-www-form-urlencoded",
                "Accept" => "application/json",
            ])->get("https://discord.com/api//guilds/{$guild_id}/members/{$member->user->discord_id}");

            $discord_user = json_decode($response->getBody()->getContents(), true);

            Cache::put('_discord_member_'.$member->user->discord_id, $discord_user, 86400); # cache for 24 hours
        }

        return $discord_user;
    }

}
