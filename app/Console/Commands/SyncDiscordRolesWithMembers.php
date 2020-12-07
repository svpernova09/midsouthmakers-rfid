<?php

namespace App\Console\Commands;

use App\Member;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Spatie\WebhookServer\WebhookCall;

class SyncDiscordRolesWithMembers extends Command
{
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
            if($member->admin){
                $this->setAdminRole($member);
            }
            if($member->active){
                $this->setMemberRole($member);
            }
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
        ])->put("https://discord.com/api/guilds/{$guild_id}/members/{$member->user->discord_id}/roles/784609154165768203");
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
        ])->put("https://discord.com/api/guilds/{$guild_id}/members/{$member->user->discord_id}/roles/784606833456185346");
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
}
