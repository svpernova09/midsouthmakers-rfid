<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAttemptRequest;
use App\LoginAttempt;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\WebhookServer\WebhookCall;

class LoginAttemptController extends Controller
{
    public function create(LoginAttemptRequest $request)
    {
        $login = new \App\LoginAttempt;
        $login->key = $request->key;
        $login->timestamp = Carbon::createFromTimeStamp($request->timestamp);
        $login->reason = $request->reason;
        $login->result = $request->result;

        if ($request->result === 'success') {
            $this->updateLastLoginForMember($login->key);
        }

        $response = $this->notifyDiscord($login);

        return ['status' => $login->save()];
    }

    private function updateLastLoginForMember($key)
    {
        try {
            $member = Member::where('key', $key)->firstOrFail();

            $member->last_login = date('Y-m-d');
            $member->save();
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
    }

    private function notifyDiscord($login){
        $member = Member::where('key', $login->key)->first();

        $content = "Access {$login->result} for user {$member->irc_name}";
        return WebhookCall::create()
                   ->url(config('services.discord.door_webhook_url'))
                   ->payload([
                       'username' => 'MMDoorBot',
                       'avatar_url' => '',
                       'content' => $content,
                   ])
                   ->doNotSign()
                   ->dispatch();
    }
}
