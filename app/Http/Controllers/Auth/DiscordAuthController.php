<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendDiscordAuthEmailRequest;
use App\Mail\VerifyDiscordAccount;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class DiscordAuthController extends Controller
{
    public function sendAuthEmail(SendDiscordAuthEmailRequest $request){
        Log::info($request);
        $email = $request->input('content');
        $user = User::where('email', $email)->first();
        $user->author_id = $request->input('author_id');
        $user->discord_username = $request->input('discord_username');
        $user->discord_hash = Password::getRepository()->createNewToken();

        Cache::add('discord_auth_'.$user->id, $user);
        Mail::to($user->email)->send(new VerifyDiscordAccount($user));

        return response()->json(['ok']);
    }

    public function attemptVerify(Request $request, $hash)
    {
        $input_hash = $request->input('hash');
        $user = Auth::user();
        $cached_user = Cache::get('discord_auth_'.$user->id);

        if ($input_hash === $cached_user->discord_hash)
        {
            $user->discord_id = $cached_user->author_id;
            $user->discord_username = $cached_user->discord_username;
            $user->save();
        } else {
            throw new BadRequestHttpException('Bad Request');
        }

        return response()->redirectToRoute('home');
    }
}
